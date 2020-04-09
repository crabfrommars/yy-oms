<?php


namespace app\wxpay\controller;
use app\common\controller\Base;
use think\facade\Request;
use app\common\model\WxUser;
use app\common\model\Guide;

class WeChat extends Base
{
    private $appid='wxb4e734264e6e7991';  // 小程序appid
    private $appsecret='c1e74bb9770d3f8387969673af540419';  // 小程序密钥
    private $key='io4JLKhewwGWfbOq2j9xFjt3vpHugTAW';  // 商户密钥
    private $url='';  // 微信回调地址
    private $mchId='1541493881';  // 微信商户号

    /**
     * @return false|string
     * 登录微信获取openid和session_key
     */
    public function login()
    {
        $code=Request::request('code');
        $name=Request::request('name');
        if($name == 'bld'){
            $appid='wx6337cae2bcb2c289';
            $appsecret='d5790198600382ce10ea3252c9b79cb3';
        }else{
            $appid='wxb4e734264e6e7991';
            $appsecret='c1e74bb9770d3f8387969673af540419';
        }

        $this->url='https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$appsecret.'&js_code='.$code.'&grant_type=authorization_code';
        $res=file_get_contents($this->url);
        return $res;
    }

    /**
     * 用户鉴权
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function checkUser()
    {
        $data=Request::request();
        $res=[];
        $user=WxUser::where('openid',$data['openid'])->find();
        if($user){
            $res=[
                'code'=>0,
                'rank'=>$user->rank
            ];
        }else{
            $res=[
                'code'=>1,
                'rank'=>null
            ];
        }

        return $res;
    }

    public function saveUser()
    {
        $data=Request::request();
//        $data=['openid'=>'otAV85RXO27egM4DcKRF4IHGXxWo'];
        if (!WxUser::where('openid',$data['openid'])->find()){
            $user=WxUser::create($data);
        }else{
            $user=WxUser::where('openid',$data['openid'])->find();
        }
//        $res=[
//            'user'=>$user
//        ];
        return $user;
    }

    public function getPic()
    {
        $data=Request::request();
        $res=[];
        if($data['target'] == 'guide'){
            $img1=Guide::where('id',1)->find();
            $img2=Guide::where('id',2)->find();
            $res=[
//                'img1Src'=>'http://192.168.0.53'.$img1->address,
//                'img2Src'=>'http://192.168.0.53'.$img2->address
                'img1Src'=>'https://oms.yuyangking.com'.$img1->address,
                'img2Src'=>'https://oms.yuyangking.com'.$img2->address
            ];
        }
        return $res;
    }

    /**
     * 下单
     * @return false|string
     */
    public function placeOrder()
    {

        $code=Request::request('code'); // 微信登录code
        $name=Request::request('name');
        if($name == 'bld'){
            $appid='wx6337cae2bcb2c289';
            $appsecret='d5790198600382ce10ea3252c9b79cb3';
        }else{
            $appid='wxb4e734264e6e7991';
            $appsecret='c1e74bb9770d3f8387969673af540419';
        }
        $loginUrl='https://api.weixin.qq.com/sns/jscode2session?appid='.$appid  // 微信登录接口
            .'&secret='.$appsecret
            .'&js_code='.$code
            .'&grant_type=authorization_code';
//        $loginRes=file_get_contents($loginUrl);  // 登录结果

        $deviceInfo='WEB';  // 设备号
        $nonceStr=$this->getRandomStr(32,false);  // 随机字符串
        $body='宇扬科技-售后延保';  // 商品描述
        $outTradeNo=$this->getOrderSn();  // 订单号
        $totalFee=Request::request('total_fee');  // 交易金额
        $openId=json_decode(file_get_contents($loginUrl),true)['openid'];  // 用户openid

        $request=Request::instance();
        $spbillCreateIp=$request->ip();  // 终端ip
        $notifyUrl='https://oms.yuyangking.com/wxpay/we_chat/payResult';  // 支付结果异步通知地址
        $tradeType='JSAPI';  // 交易类型

        // 将要签名的参数整合为数组
        $options=[
            'appid'=>$appid
            , 'body'=>$body
            , 'device_info'=>$deviceInfo
            , 'nonce_str'=>$nonceStr
            , 'notify_url'=>$notifyUrl
            , 'openid'=>$openId
            , 'out_trade_no'=>$outTradeNo
            , 'spbill_create_ip'=>$spbillCreateIp
            , 'total_fee'=>$totalFee
            , 'trade_type'=>$tradeType
            , 'mch_id'=>$this->mchId
        ];

        // 第一次签名
        $sign=$this->sign($options);

        // 将签名结果加入到数组中
        $options['sign']=$sign;

        // 数组转换为xml格式
        $xml=$this->array2xml($options);

        $apiUrl='https://api.mch.weixin.qq.com/pay/unifiedorder';  // 统一下单接口

        // 将xml发送到统一下单接口，获取接口返回的数据并转换成数组
        $res=$this->postXmlCurl('',$xml,$apiUrl);
        $resArr=$this->xml2array($res);

        // 设定要再次签名的参数数组
        $optionsPay=[
            'appId'=>$resArr['appid']
            , 'timeStamp'=>(string)time()
            , 'nonceStr'=>$resArr['nonce_str']
            , 'package'=>'prepay_id='.$resArr['prepay_id']
            , 'signType'=>'MD5'
        ];

        // 第二次签名
        $signPay=$this->sign($optionsPay);

        // 将签名加入到数组中
        $optionsPay['paySign']=$signPay;

        // 将最终数组数据返回到前端
        return json_encode($optionsPay);
    }

    /**
     * 接收支付结果通知
     */
    public function payResult()
    {
        // 接收微信的通知
        $xml=Request::request();

        // 如果没有数据，返回失败
        if (empty($xml)){
            return false;
        }

        // 有数据则验证签名
        // 将通知结果转换为数组
        $notifyArr=$this->xml2array($xml);

        // 通信成功且交易成功
        if ($notifyArr['return_code'] == 'SUCCESS' && $notifyArr['result_code'] == 'SUCCESS'){
            // 对数据进行一次签名
            $mySign=$this->sign($notifyArr);

            // 校验签名是否一致
            if ($mySign === $notifyArr['sign']){
                // 查询订单
                $res=$this->order($notifyArr['transaction_id']);

                // 若查询订单已完成且金额与通知金额一致
                if ($res['trade_state'] == 'SUCCESS' && $res['total_fee'] == $notifyArr['total_fee']){
                    // 设定要返回给微信的参数
                    $options=[
                        'return_code'=>'SUCCESS'
                        , 'return_msg'=>'OK'
                    ];

                    // 参数转为xml
                    $response=$this->array2xml($options);

                    // 返回参数
                    return $response;
                }
            };
        }

    }

    /**查询订单
     * @param $transactionId
     * @return mixed
     */
    private function order($transactionId)
    {
        $url='https://api.mch.weixin.qq.com/pay/orderquery';  // 查询订单接口
        $name=Request::request('name');
        if($name == 'bld'){
            $appid='wx6337cae2bcb2c289';
        }else{
            $appid='wxb4e734264e6e7991';
        }

        // 设定请求参数(不包含签名)
        $options=[
            'appid'=>$appid
            , 'mch_id'=>$this->mchId
            , 'transaction_id'=>$transactionId
            , 'nonce_str'=>$this->getRandomStr(32)
        ];

        // 对参数签名
        $sign=$this->sign($options);

        // 将签名加入到参数中
        $options['sign']=$sign;

        // 将参数转换为xml格式
        $xml=$this->array2xml($options);

        // 发送请求
        $res=$this->postXmlCurl('',$xml,$url);

        // 将结果转换为数组
        $result=$this->xml2array($res);

        // 返回结果
        return $result;
    }

    /**
     * 获取随机字符串
     * @param $len  需要的长度
     * @param bool $special  是否需要特殊符号
     * @return string  返回随机字符串
     */
    private function getRandomStr($len, $special=true){
        $chars = array(
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
            "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
            "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
            "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
            "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
            "3", "4", "5", "6", "7", "8", "9"
        );

        if($special){
            $chars = array_merge($chars, array(
                "!", "@", "#", "$", "?", "|", "{", "/", ":", ";",
                "%", "^", "&", "*", "(", ")", "-", "_", "[", "]",
                "}", "<", ">", "~", "+", "=", ",", "."
            ));
        }

        $charsLen = count($chars) - 1;
        shuffle($chars);                            //打乱数组顺序
        $str = '';
        for($i=0; $i<$len; $i++){
            $str .= $chars[mt_rand(0, $charsLen)];    //随机取出一位
        }
        return $str;
    }

    /**
     * 生成签名
     * @param $body
     * @param $deviceInfo
     * @param $nonceStr
     * @return string
     */
    private function sign(array $options)
    {
        // 去除数组中的空值
        $arr = array_filter($options);

        // 如果数组中有签名删除签名
        if(isset($arr['sign']))
        {
            unset($arr['sign']);
        }

        // 按照键名字典排序
        ksort($arr);

        // 生成URL格式的字符串
        // http_build_query()中文自动转码需要处理下
        $str = http_build_query($arr).'&key='.$this->key;
        $str = urldecode($str);

        return  strtoupper(md5($str));
    }

    /**
     * 生成唯一订单号
     * @return string
     */
    private function getOrderSn()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
        return $orderSn;
    }

    /**
     * 发送http请求
     * @param $url
     * @param array $options
     * @return bool|string
     */
    private function sendHttp($url,$post_data)
    {
        $postdata = http_build_query($post_data);

        $options = array(

            'http' => array(

                'method' => 'POST',

                'header' => 'Content-type:application/x-www-form-urlencoded',

                'content' => $postdata,

                'timeout' => 15 * 60 // 超时时间（单位:s）

            )

        );

        $context = stream_context_create($options);

        $result = file_get_contents($url, false, $context);

        return $result;
    }

    /**
     * POST发送xml
     * @param $config
     * @param $xml
     * @param $url
     * @param bool $useCert
     * @param int $second
     * @return bool|string
     */
    private function postXmlCurl($config, $xml, $url, $useCert = false, $second = 30)
    {
        $ch = curl_init();
        //$curlVersion = curl_version();
        //$ua = "WXPaySDK/".self::$VERSION." (".PHP_OS.") PHP/".PHP_VERSION." CURL/".$curlVersion['version']." "
        //    .$config->GetMerchantId();

        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);

//    $proxyHost = "0.0.0.0";
//    $proxyPort = 0;
//    $config->GetProxy($proxyHost, $proxyPort);
//    //如果有配置代理这里就设置代理
//    if($proxyHost != "0.0.0.0" && $proxyPort != 0){
//        curl_setopt($ch,CURLOPT_PROXY, $proxyHost);
//        curl_setopt($ch,CURLOPT_PROXYPORT, $proxyPort);
//    }
        curl_setopt($ch, CURLOPT_URL, $url);
        //curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
        //curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        //curl_setopt($ch,CURLOPT_USERAGENT, $ua);
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        if ($useCert == true) {
            //设置证书
            //使用证书：cert 与 key 分别属于两个.pem文件
            //证书文件请放入服务器的非web目录下
            $sslCertPath = "";
            $sslKeyPath = "";
            $config->GetSSLCertPath($sslCertPath, $sslKeyPath);
            curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLCERT, $sslCertPath);
            curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
            curl_setopt($ch, CURLOPT_SSLKEY, $sslKeyPath);
        }
        //试试手气新增，增加之后 curl 不报 60# 错误，可以请求到微信的响应
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  //不验证 SSL 证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//不验证 SSL 证书域名
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if ($data) {
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            return "curl error, error code ".$error;
            //throw new WxPayException("curl出错，错误码:$error");
        }
    }

    /**
     * 数组转xml
     * @param $params
     * @return bool|string
     */
    private function array2xml($params)
    {
        if(!is_array($params)|| count($params) <= 0)
        {
            return false;
        }
        $xml = "<xml>\n";
        foreach ($params as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">\n";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">\n";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    /**
     * xml转数组
     * @param $xml
     * @return mixed
     */
    private function xml2array($xml)
    {
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $values;
    }

    public function test()
    {
        $deviceInfo='WEB';  // 设备号
        $nonceStr=$this->getRandomStr(32,false);  // 随机字符串
        $body='宇扬科技-售后延保';  // 商品描述
        $outTradeNo=$this->getOrderSn();  // 订单号
//        $totalFee=Request::request('total_fee');  // 交易金额
//        $openId=Request::request('openid');
        $totalFee=500;  // 交易金额
        $openId='otAV85RXO27egM4DcKRF4IHGXxWo';

        $request=Request::instance();
        $spbillCreateIp=$request->ip();  // 终端ip
        $notifyUrl='https://oms.yuyangking.com/wxpay/we_chat/payResult';  // 支付结果通知地址
        $tradeType='JSAPI';  // 交易类型

        $options=[
            'appid'=>$this->appid
            , 'body'=>$body
            , 'device_info'=>$deviceInfo
            , 'nonce_str'=>$nonceStr
            , 'notify_url'=>$notifyUrl
            , 'openid'=>$openId
            , 'out_trade_no'=>$outTradeNo
            , 'spbill_create_ip'=>$spbillCreateIp
            , 'total_fee'=>$totalFee
            , 'trade_type'=>$tradeType
            , 'mch_id'=>$this->mchId
        ];

        // 签名
        $sign=$this->sign($options);

        // 将签名加入到要传输的数组中
        $options['sign']=$sign;

        // 参数转换为xml格式
        $xml=$this->array2xml($options);

        $apiUrl='https://api.mch.weixin.qq.com/pay/unifiedorder';  // 统一下单接口

        // 获取接口返回的数据并转换成数组
        $res=$this->postXmlCurl('',$xml,$apiUrl);
        $resArr=$this->xml2array($res);

        // 设定要再次签名的参数数组
        $optionsPay=[
            'appId'=>$resArr['appid']
            , 'timeStamp'=>time()
            , 'nonceStr'=>$resArr['nonce_str']
            , 'package'=>'prepay_id='.$resArr['prepay_id']
            , 'signType'=>'MD5'
        ];

        // 签名
        $signPay=$this->sign($optionsPay);

        // 将签名加入到数组中
        $optionsPay['paySign']=$signPay;

        dump($this->array2xml($optionsPay));
    }

    public function test2()
    {
        $res=$this->order('4200000331201907045140182519');
        dump($res);
    }
}