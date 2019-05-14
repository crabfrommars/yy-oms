-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1:3306
-- 生成日期： 2019-05-10 09:18:57
-- 服务器版本： 5.7.24
-- PHP 版本： 7.2.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `yy_test`
--

-- --------------------------------------------------------

--
-- 表的结构 `controller`
--

DROP TABLE IF EXISTS `controller`;
CREATE TABLE IF NOT EXISTS `controller` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(55) NOT NULL COMMENT '名称',
  `model` varchar(55) NOT NULL COMMENT '型号',
  `serial` varchar(255) NOT NULL COMMENT '序列号',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='控制器列表';

--
-- 转存表中的数据 `controller`
--

INSERT INTO `controller` (`id`, `name`, `model`, `serial`, `create_time`, `update_time`) VALUES
(1, '江海', 'YKZ7280JA', 'A10105088', 1551848390, 1551848390),
(2, '宇扬', 'YKZ120150FB', 'B665843398', 1551850150, 1551850150);

-- --------------------------------------------------------

--
-- 表的结构 `drawings`
--

DROP TABLE IF EXISTS `drawings`;
CREATE TABLE IF NOT EXISTS `drawings` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `path` varchar(255) DEFAULT NULL COMMENT '路径',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='图纸存放';

--
-- 转存表中的数据 `drawings`
--

INSERT INTO `drawings` (`id`, `name`, `path`, `create_time`, `update_time`) VALUES
(7, '247_WEPED_YKZ_12BP_15CM_2019-2-19.pdf', '/uploads/247_WEPED_YKZ_12BP_15CM_2019-2-19.pdf', 1551422429, 1551422749),
(11, '', '', 1551431256, 1555918887),
(12, '', '', 1553590428, 1553666449);

-- --------------------------------------------------------

--
-- 表的结构 `options`
--

DROP TABLE IF EXISTS `options`;
CREATE TABLE IF NOT EXISTS `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `type` varchar(32) NOT NULL,
  `value` varchar(16) NOT NULL,
  `text` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=114 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `options`
--

INSERT INTO `options` (`id`, `type`, `value`, `text`) VALUES
(1, 'shell_type', '无', '无'),
(2, 'shell_type', 'YKZ_一代', 'YKZ_一代'),
(3, 'shell_type', 'YKS_二代', 'YKS_二代'),
(4, 'shell_type', 'YKF_三代', 'YKF_三代'),
(5, 'shell_type', 'YKT_雷舜定制壳', 'YKT_雷舜定制壳'),
(6, 'shell_type', 'YKE_新一代', 'YKE_新一代'),
(7, 'shell_type', 'YKG_改装车专用', 'YKG_改装车专用'),
(8, 'shell_type', 'YKL_瑞丰强散热', 'YKL_瑞丰强散热'),
(9, 'shell_type', 'YKW_一代铸铝壳', 'YKW_一代铸铝壳'),
(10, 'shell_type', 'YKX_一代增强版', 'YKX_一代增强版'),
(12, 'shell_type', 'YKA_宇扬星铸铝壳', 'YKA_宇扬星铸铝壳'),
(13, 'shell_type', '其他', '其他'),
(14, 'shell_color', '原色', '原色'),
(15, 'shell_color', '1_金色', '1_金色'),
(16, 'shell_color', '2_蓝色', '2_蓝色'),
(17, 'shell_color', '3_黑色', '3_黑色'),
(18, 'shell_color', '4_铁灰色', '4_铁灰色'),
(19, 'shell_color', '其他', '其他'),
(20, 'mos', 'A_STP75NF75', 'A_STP75NF75'),
(21, 'mos', 'B_IRF1407PbF', 'B_IRF1407PbF'),
(22, 'mos', 'C_TK150E09NE', 'C_TK150E09NE'),
(23, 'mos', 'D_IRFB4310ZPbF', 'D_IRFB4310ZPbF'),
(24, 'mos', 'E_IRFB4115GPbF', 'E_IRFB4115GPbF'),
(25, 'mos', 'F_IRFP4568PbF', 'F_IRFP4568PbF'),
(26, 'mos', 'G_IRFP4468PbF', 'G_IRFP4468PbF'),
(27, 'mos', 'H_IRFB4110PbF', 'H_IRFB4110PbF'),
(28, 'mos', 'I_S80N08RN', 'I_S80N08RN'),
(29, 'mos', 'I_S90N45R', 'I_S90N45R'),
(30, 'mos', 'I_SKTT078N08N', 'I_SKTT078N08N'),
(31, 'mos', 'J_S10H12R', 'J_S10H12R'),
(32, 'mos', 'K_YY85N70', 'K_YY85N70'),
(33, 'mos', 'L_IRFP2907', 'L_IRFP2907'),
(34, 'mos', 'M_STP80NF70', 'M_STP80NF70'),
(35, 'mos', 'N_IRFP4110PBF', 'N_IRFP4110PBF'),
(36, 'mos', 'O_MDP1991', 'O_MDP1991'),
(37, 'mos', 'P_S15H12R', 'P_S15H12R'),
(38, 'mos', 'Q_GT50JR22', 'Q_GT50JR22'),
(39, 'mos', 'R_IKW25N120H3', 'R_IKW25N120H3'),
(40, 'mos', 'S_IRFP4668PBF', 'S_IRFP4668PBF'),
(41, 'mos', 'T_IKW40N120H3', 'T_IKW40N120H3'),
(42, 'mos', 'U_IKW15N120H3', 'U_IKW15N120H3'),
(43, 'mos', '其他', '其他'),
(44, '', '', ''),
(45, 'board', '无', '无'),
(46, 'board', 'A_YY24AP_HQ', 'A_YY24AP_HQ'),
(47, 'board', 'B_YY24BP_DHQ', 'B_YY24BP_DHQ'),
(48, 'board', 'C_YY36AP_HQ', 'C_YY36AP_HQ'),
(49, 'board', 'D_YY36BP', 'D_YY36BP'),
(50, 'board', 'E_YY36AP', 'E_YY36AP'),
(51, 'board', 'F_YY36FOC', 'F_YY36FOC'),
(52, 'board', 'G_YY18BP_HQ', 'G_YY18BP_HQ'),
(53, 'board', 'H_YY24EP_DHQ', 'H_YY24EP_DHQ'),
(54, 'board', 'I_YY24BP_FHQ', 'I_YY24BP_FHQ'),
(55, 'board', 'J_ZY18CP', 'J_ZY18CP'),
(56, 'board', 'K_ZY15CP', 'K_ZY15CP'),
(57, 'board', 'L_ZY12CP', 'L_ZY12CP'),
(58, 'board', 'M_ZY12BP', 'M_ZY12BP'),
(59, 'board', 'N_ZY12BP', 'N_ZY12BP'),
(60, 'board', 'O_ZY09BP', 'O_ZY09BP'),
(61, 'board', 'P_ZY09CP', 'P_ZY09CP'),
(62, 'board', 'Q_ZY06BP', 'Q_ZY06BP'),
(63, 'board', 'R_ZY06CP', 'R_ZY06CP'),
(64, 'board', 'S_YY30BP_HQ', 'S_YY30BP_HQ'),
(65, 'board', 'T_YY18CP_HQ', 'T_YY18CP_HQ'),
(66, 'board', 'U_YY18FOC', 'U_YY18FOC'),
(67, 'board', 'V_协昌12管', 'V_协昌12管'),
(68, 'board', 'W_YY18EP_HQ', 'W_YY18EP_HQ'),
(69, 'board', 'X_YY24EP_HQ', 'X_YY24EP_HQ'),
(70, 'board', 'Y_YY12FOC_HQ', 'Y_YY12FOC_HQ'),
(71, 'board', '0X_YY24FOC', '0X_YY24FOC'),
(72, 'board', '0A_YYX24BP_HQ', '0A_YYX24BP_HQ'),
(73, 'board', '0B_YY06AP_HQ', '0B_YY06AP_HQ'),
(74, 'board', '0C_BOLEEE', '0C_BOLEEE D3012_12M3_Y1.1'),
(75, 'board', '客户定制', '客户定制'),
(76, 'normal_func', '1', '防盗'),
(77, 'normal_func', '2', 'EBS刹车'),
(78, 'normal_func', '3', '上电防飞车'),
(79, 'normal_func', '4', '运行防飞车'),
(80, 'normal_func', '5', '双模'),
(81, 'normal_func', '6', '随压'),
(82, 'normal_func', '7', '倒车'),
(83, 'normal_func', '8', '空挡'),
(84, 'normal_func', '9', '高刹'),
(85, 'normal_func', '10', '低刹'),
(86, 'normal_func', '11', '霍尔仪表'),
(87, 'normal_func', '12', '相线仪表'),
(88, 'normal_func', '13', '正反转'),
(89, 'normal_func', '14', '自学习'),
(90, 'normal_func', '15', '限速'),
(91, 'special_func', '1', '助力'),
(92, 'special_func', '2', '语音'),
(93, 'special_func', '3', '一线通'),
(94, 'special_func', '4', '液晶仪表'),
(95, 'special_func', '5', '电磁阀'),
(96, 'special_func', '6', '光耦启动器'),
(97, 'special_func', '7', '双欠压'),
(98, 'special_func', '8', '电流选择'),
(99, 'special_func', '9', '其他'),
(100, 'wires', '1', '转把线'),
(101, 'wires', '2', '高刹线'),
(102, 'wires', '3', '低刹线'),
(103, 'wires', '4', '霍尔仪表线'),
(104, 'wires', '5', '相线仪表线'),
(105, 'wires', '6', '手动巡航线'),
(106, 'wires', '7', '软硬启选择线'),
(107, 'wires', '8', '正反转选择线'),
(108, 'wires', '9', '限速线'),
(109, 'wires', '10', '自学习线'),
(110, 'wires', '11', '助力线'),
(111, 'wires', '12', '多功能线'),
(112, 'wires', '13', '电压选择线'),
(113, 'wires', '14', '电流选择线');

-- --------------------------------------------------------

--
-- 表的结构 `order`
--

DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `factory` varchar(16) DEFAULT NULL COMMENT '加工厂',
  `pro_type` varchar(16) NOT NULL DEFAULT '电动车类应用' COMMENT '产品类型',
  `order_type` varchar(16) NOT NULL DEFAULT '成品单' COMMENT '订单类型',
  `appoint_auditor` varchar(16) NOT NULL DEFAULT '项小成' COMMENT '指定审核人',
  `customer` varchar(255) NOT NULL COMMENT '客户名',
  `salesman` varchar(55) NOT NULL COMMENT '业务员',
  `model` varchar(55) NOT NULL COMMENT '型号',
  `quantity` int(11) NOT NULL COMMENT '数量',
  `delivery` tinyint(4) NOT NULL COMMENT '交期',
  `serial_start` varchar(32) DEFAULT NULL COMMENT '单批次第一个序列号',
  `serial_end` varchar(32) DEFAULT NULL COMMENT '单批次最后一个序列号',
  `this_t6` int(16) DEFAULT NULL COMMENT '本单T6号',
  `mother_t6` int(16) DEFAULT NULL COMMENT '母单T6号',
  `shell_type` varchar(55) NOT NULL COMMENT '外壳类型',
  `shell_color` varchar(16) NOT NULL COMMENT '外壳颜色',
  `baffle` varchar(16) NOT NULL COMMENT '挡板类型',
  `mos` varchar(55) NOT NULL COMMENT 'mos管',
  `board` varchar(55) NOT NULL COMMENT '板卡',
  `elect_machine` varchar(55) NOT NULL COMMENT '电机类型',
  `wire_label` varchar(55) NOT NULL COMMENT '线束标签',
  `shell_label` varchar(55) NOT NULL COMMENT '外壳标签',
  `vol1` float NOT NULL COMMENT '额定电压1',
  `amp1` float NOT NULL COMMENT '额定电流1',
  `undervoltage1` float NOT NULL COMMENT '欠压值1',
  `vol2` float NOT NULL DEFAULT '0' COMMENT '额定电压2',
  `amp2` float NOT NULL DEFAULT '0' COMMENT '额定电流2',
  `undervoltage2` float NOT NULL DEFAULT '0' COMMENT '欠压值2',
  `power` float NOT NULL COMMENT '功率',
  `bluetooth` varchar(55) NOT NULL COMMENT '蓝牙',
  `diameter` varchar(16) DEFAULT NULL COMMENT '高温线径',
  `phase` varchar(55) NOT NULL COMMENT '相序',
  `length` varchar(55) NOT NULL COMMENT '外露长度',
  `is_water` tinyint(4) NOT NULL COMMENT '是否水冷1是2否',
  `is_wire` tinyint(4) NOT NULL COMMENT '是否线束可拆装1是2否',
  `r27` varchar(16) DEFAULT NULL COMMENT '功率电阻R27',
  `r4` varchar(16) DEFAULT NULL COMMENT '功率电阻R4',
  `electrolytic_capacitor` varchar(16) DEFAULT NULL COMMENT '大电解',
  `software` varchar(255) DEFAULT NULL COMMENT '软件名',
  `normal_func` varchar(255) DEFAULT NULL COMMENT '常规功能',
  `func_cruise` varchar(16) NOT NULL COMMENT '巡航',
  `func_soft_hard` varchar(16) NOT NULL COMMENT '软硬启',
  `func_gear` varchar(16) NOT NULL COMMENT '三挡',
  `special_func` varchar(255) DEFAULT NULL COMMENT '特殊功能',
  `wire_type` varchar(16) NOT NULL COMMENT '线束类型',
  `drawing_func_wires_num` varchar(55) DEFAULT NULL COMMENT '图纸编号',
  `bom_id` int(16) DEFAULT '0' COMMENT 'BOM编号',
  `wires` varchar(255) DEFAULT NULL COMMENT '线束',
  `wire_holzer` varchar(16) NOT NULL COMMENT '霍尔线',
  `wire_elect_lock` varchar(16) NOT NULL COMMENT '电门锁线',
  `wire_guard` varchar(16) NOT NULL COMMENT '防盗线',
  `wire_reverse` varchar(16) NOT NULL COMMENT '倒车线',
  `wire_gear` varchar(16) NOT NULL COMMENT '三档线',
  `remark` text COMMENT '业务备注',
  `remark_tech` text COMMENT '研发备注',
  `remark_production` text COMMENT '生产备注',
  `is_mother` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否母单0否1是',
  `progress` varchar(10) NOT NULL DEFAULT '30%' COMMENT '进度',
  `review_id` int(11) DEFAULT NULL COMMENT '关联评审单编号',
  `create_time` int(10) NOT NULL,
  `update_time` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `order`
--

INSERT INTO `order` (`id`, `factory`, `pro_type`, `order_type`, `appoint_auditor`, `customer`, `salesman`, `model`, `quantity`, `delivery`, `serial_start`, `serial_end`, `this_t6`, `mother_t6`, `shell_type`, `shell_color`, `baffle`, `mos`, `board`, `elect_machine`, `wire_label`, `shell_label`, `vol1`, `amp1`, `undervoltage1`, `vol2`, `amp2`, `undervoltage2`, `power`, `bluetooth`, `diameter`, `phase`, `length`, `is_water`, `is_wire`, `r27`, `r4`, `electrolytic_capacitor`, `software`, `normal_func`, `func_cruise`, `func_soft_hard`, `func_gear`, `special_func`, `wire_type`, `drawing_func_wires_num`, `bom_id`, `wires`, `wire_holzer`, `wire_elect_lock`, `wire_guard`, `wire_reverse`, `wire_gear`, `remark`, `remark_tech`, `remark_production`, `is_mother`, `progress`, `review_id`, `create_time`, `update_time`) VALUES
(1, '晟楠', '电动车类应用', '成品单', '项小成', 'test', 'test', 'test', 12, 12, 'A0199012A', 'A0199088A', 0, 0, 'YKS_二代', '1_金色', '无字', 'B_IRF1407PbF', 'A_YY24AP_HQ', '差速电机', '接插件小标签', '无', 12, 32, 12, 0, 0, 0, 12, '无', '8mm²', '宇扬公版', '25CM', 2, 2, '高压小板', '22Ω/1W', '1000uF/80V', '666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666', '1,4,5,6,7,8,9,10,11,14,15', '无', '无', '无', '1,2,3,4,5,6,7,8,9', '宇扬标准', '', 0, '1,2,3,4,5,6,7,8,9,10,11,12,13,14', '普通', '子弹头', '3+2', '空挡倒车', '拨动三档', '666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666', '666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666', '666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666', 0, '30%', 1, 1556439015, 1557123217),
(2, '艾芯', '新产品应用', '样品单', '莫刚强', '测试', '测试', '测试', 2, 2, 'A0199012A', 'A0199088A', 1214, 2123, '无', '原色', '无', 'G_IRFP4468PbF', 'F_YY36FOC', '差速电机', '线束大标签', '无', 2, 2, 2, 0, 0, 0, 2, '无', '10mm²', '宇扬公版', '35CM', 2, 2, '47Ω/1W', '47Ω/1W', '1000uF/100V', '', '1,14,15', '自动巡航', '硬启动', '拨动三档', '4,5,6', '宇扬标准', '', 565, '3,13', '无', '无', '无', '无', '无', '测试', '测试', '测试', 0, '50%', 2, 1556525005, 1557453237),
(3, NULL, '电动车类应用', '成品单', '项小成', 'test', '呵呵呵', 'test', 12, 12, NULL, NULL, NULL, NULL, 'YKS_二代', '1_金色', '无字', 'B_IRF1407PbF', 'A_YY24AP_HQ', '差速电机', '接插件小标签', '无', 12, 32, 12, 0, 0, 0, 12, '无', NULL, '宇扬公版', '25CM', 2, 2, NULL, NULL, NULL, NULL, '', '无', '无', '无', '', '宇扬标准', '', 0, '', '普通', '子弹头', '3+2', '空挡倒车', '拨动三档', '6666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666666', NULL, NULL, 1, '20%', 4, 1557369879, 1557453040);

-- --------------------------------------------------------

--
-- 表的结构 `progress`
--

DROP TABLE IF EXISTS `progress`;
CREATE TABLE IF NOT EXISTS `progress` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `value` varchar(8) NOT NULL,
  `content` varchar(32) NOT NULL,
  `role` int(11) NOT NULL COMMENT '角色id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `value` (`value`),
  KEY `role_id` (`role`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `progress`
--

INSERT INTO `progress` (`id`, `value`, `content`, `role`) VALUES
(1, '10%', '编辑订单', 13),
(2, '20%', '配发评审单', 13),
(3, '30%', '审核订单', 7),
(4, '40%', '审核订单', 4),
(5, '50%', '配发文件', 6),
(6, '60%', '审核订单', 17),
(7, '70%', '配料', 18),
(8, '80%', '生产加工', 16),
(9, '90%', '装箱打包', 19),
(10, '95%', '发货', 14),
(11, '100%', '完成', 999);

-- --------------------------------------------------------

--
-- 表的结构 `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `order_id` int(11) NOT NULL COMMENT '订单号',
  `customer` varchar(64) NOT NULL COMMENT '客户名',
  `project_name` varchar(128) NOT NULL COMMENT '项目名',
  `applicant` varchar(16) NOT NULL COMMENT '申请人',
  `app_department` varchar(16) NOT NULL COMMENT '申请部门',
  `app_date` date NOT NULL COMMENT '申请日期',
  `pro_time` varchar(32) NOT NULL COMMENT '量产时间',
  `pro_scale` varchar(32) NOT NULL COMMENT '量产规模',
  `description` varchar(64) NOT NULL COMMENT '型号（描述）',
  `price` decimal(10,2) NOT NULL COMMENT '售价',
  `project_bg` text NOT NULL COMMENT '项目背景',
  `sale_manager` varchar(16) DEFAULT NULL COMMENT '销售经理',
  `sale_department` varchar(16) DEFAULT NULL COMMENT '销售部',
  `marketing_department` varchar(16) DEFAULT NULL COMMENT '市场部',
  `situation` varchar(128) NOT NULL COMMENT '应用场景',
  `vol` float NOT NULL COMMENT '额定电压',
  `amp` float NOT NULL COMMENT '额定电流',
  `power` float NOT NULL COMMENT '额定功率',
  `tech_req` text NOT NULL COMMENT '技术要求',
  `customer_req` text COMMENT '客户要求',
  `project_ana` text COMMENT '项目分析',
  `dev_time` varchar(32) DEFAULT NULL COMMENT '开发时间',
  `priority` varchar(32) DEFAULT NULL COMMENT '优先级',
  `project_manager` varchar(16) DEFAULT NULL COMMENT '项目经理',
  `dev_department` int(11) DEFAULT NULL COMMENT '研发部',
  `sign_time` date DEFAULT NULL COMMENT '签发时间',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '0已过审1未过审',
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_id` (`order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='评审单';

--
-- 转存表中的数据 `reviews`
--

INSERT INTO `reviews` (`id`, `order_id`, `customer`, `project_name`, `applicant`, `app_department`, `app_date`, `pro_time`, `pro_scale`, `description`, `price`, `project_bg`, `sale_manager`, `sale_department`, `marketing_department`, `situation`, `vol`, `amp`, `power`, `tech_req`, `customer_req`, `project_ana`, `dev_time`, `priority`, `project_manager`, `dev_department`, `sign_time`, `status`) VALUES
(1, 1, 'test6', 'test', 'test', 'test', '2019-05-06', 'test', '22', 'test', '32.00', 'test', NULL, NULL, NULL, 'test', 12, 32, 12, 'test', '', '', '', '', NULL, NULL, NULL, 0),
(2, 2, '测试', '测试', '测试', '测试', '2019-05-06', '12', '123', '测试', '123.00', '测试', 'test', NULL, NULL, '测试', 2, 2, 2, '测试', '', '', '', '', NULL, NULL, NULL, 1),
(4, 3, 'test', 'test', '呵呵呵', 'test', '2019-05-09', 'test', '12', 'test', '124.00', '123swqade', NULL, NULL, NULL, 'adwqe', 12, 32, 12, '123wq', '', NULL, NULL, NULL, NULL, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- 表的结构 `right`
--

DROP TABLE IF EXISTS `right`;
CREATE TABLE IF NOT EXISTS `right` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(32) NOT NULL,
  `remark` varchar(55) NOT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `right`
--

INSERT INTO `right` (`id`, `name`, `remark`) VALUES
(1, 'create_order', '创建订单'),
(2, 'edit_order', '编辑订单'),
(3, 'reverse_order', '退单'),
(4, 'control_progress', '控制流程'),
(5, 'create_user', '创建用户'),
(6, 'create_drawing', '创建图纸记录'),
(7, 'edit_user', '编辑用户'),
(8, 'create_review', '创建评审单'),
(9, 'check_reviews', '查阅评审单');

-- --------------------------------------------------------

--
-- 表的结构 `role`
--

DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `role`
--

INSERT INTO `role` (`id`, `name`) VALUES
(1, '超级管理员'),
(2, '管理员'),
(3, '研发主管'),
(4, '研发经理'),
(5, '研发专员'),
(6, '研发助理'),
(7, '市场主管'),
(8, '市场经理'),
(9, '市场专员'),
(10, '市场助理'),
(11, '销售主管'),
(12, '销售经理'),
(13, '销售专员'),
(14, '销售助理'),
(15, '生产主管'),
(16, '生产经理'),
(17, '生产专员'),
(18, '生产助理'),
(19, '仓管专员'),
(999, ' ');

-- --------------------------------------------------------

--
-- 表的结构 `role_right`
--

DROP TABLE IF EXISTS `role_right`;
CREATE TABLE IF NOT EXISTS `role_right` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `role_id` int(11) NOT NULL,
  `right_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `right_id` (`right_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `role_right`
--

INSERT INTO `role_right` (`id`, `role_id`, `right_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 4, 1),
(7, 4, 2),
(8, 2, 1),
(9, 2, 2),
(10, 2, 3),
(11, 2, 4),
(12, 1, 7),
(13, 1, 8),
(14, 1, 9);

-- --------------------------------------------------------

--
-- 表的结构 `timeline`
--

DROP TABLE IF EXISTS `timeline`;
CREATE TABLE IF NOT EXISTS `timeline` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `order_id` int(11) NOT NULL COMMENT '订单编号',
  `action` varchar(55) NOT NULL COMMENT '操作类型',
  `content` varchar(255) NOT NULL COMMENT '内容',
  `personnel` varchar(16) NOT NULL COMMENT '人员',
  `create_time` int(10) NOT NULL COMMENT '创建时间',
  `update_time` int(10) NOT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `timeline`
--

INSERT INTO `timeline` (`id`, `order_id`, `action`, `content`, `personnel`, `create_time`, `update_time`) VALUES
(1, 1, '创建订单', '无', '解宜江', 1556439015, 1556439015),
(2, 2, '创建订单', '无', '解宜江', 1556525005, 1556525005),
(3, 3, '创建订单', '无', '解宜江', 1557369879, 1557369879),
(4, 3, '流转至：40% | 审核订单 | 研发经理', 'dxfgdfg ', '解宜江', 1557371936, 1557371936),
(5, 3, '流转至：10% | 编辑订单 | 销售专员', 'errtty', '解宜江', 1557371947, 1557371947),
(6, 3, '流转至：20% | 配发评审单 | 销售专员', '', '解宜江', 1557453040, 1557453040),
(7, 2, '流转至：40% | 审核订单 | 研发经理', '', '解宜江', 1557453075, 1557453075),
(8, 2, '流转至：50% | 配发文件 | 研发助理', '', '项小成', 1557453237, 1557453237);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `password` varchar(55) NOT NULL COMMENT '密码',
  `name` varchar(255) NOT NULL COMMENT '姓名',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1341 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `password`, `name`, `remark`) VALUES
(1001, 'e10adc3949ba59abbe56e057f20f883e', '项小成', ''),
(1002, 'e10adc3949ba59abbe56e057f20f883e', '吕兆锋', ''),
(1003, '164dcbee37d28f4a0391d5b617b936a0', '黄舟', ''),
(1004, 'e10adc3949ba59abbe56e057f20f883e', '莫刚强', ''),
(1006, 'e10adc3949ba59abbe56e057f20f883e', '杨献', ''),
(1010, 'e10adc3949ba59abbe56e057f20f883e', '沈芳', ''),
(1013, 'e10adc3949ba59abbe56e057f20f883e', '金崇超', ''),
(1014, 'e10adc3949ba59abbe56e057f20f883e', '袁炯', ''),
(1015, 'e10adc3949ba59abbe56e057f20f883e', '董丽娜', ''),
(1022, 'e10adc3949ba59abbe56e057f20f883e', '闻国军', ''),
(1023, '49bd2754bd9a44935216ddd91b95135a', '张好', ''),
(1031, 'e10adc3949ba59abbe56e057f20f883e', '王海阔', ''),
(1037, 'e10adc3949ba59abbe56e057f20f883e', '陶骁俊', ''),
(1063, '8203d384048da20b54b43fba33a4f584', '解宜江', ''),
(1072, 'e10adc3949ba59abbe56e057f20f883e', '吴俊华', ''),
(1092, 'e10adc3949ba59abbe56e057f20f883e', '陈秋英', ''),
(1121, 'e10adc3949ba59abbe56e057f20f883e', '杜玲', ''),
(1172, 'e10adc3949ba59abbe56e057f20f883e', '刘丽', ''),
(1197, 'e10adc3949ba59abbe56e057f20f883e', '郑赟', ''),
(1340, 'e10adc3949ba59abbe56e057f20f883e', '王玉兰', '');

-- --------------------------------------------------------

--
-- 表的结构 `user_role`
--

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `user_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `role_id` (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `user_role`
--

INSERT INTO `user_role` (`id`, `user_id`, `role_id`) VALUES
(1, 1063, 1),
(2, 1063, 5),
(3, 1001, 4),
(4, 1004, 4),
(5, 1003, 7),
(6, 1014, 3),
(7, 1031, 5),
(8, 1172, 6),
(9, 1013, 4),
(10, 1002, 12),
(11, 1006, 12),
(12, 1015, 12),
(13, 1022, 12),
(14, 1092, 12),
(15, 1121, 14),
(16, 1197, 13),
(17, 1031, 6),
(18, 1013, 5),
(21, 1010, 16),
(22, 1037, 16),
(23, 1072, 17),
(24, 1340, 17),
(25, 1023, 14),
(26, 1001, 2),
(27, 1002, 2),
(28, 1003, 2),
(29, 1004, 2),
(30, 1006, 2),
(31, 1010, 2),
(32, 1013, 2),
(33, 1014, 2),
(34, 1015, 2),
(35, 1022, 2),
(36, 1023, 2),
(37, 1031, 2),
(38, 1037, 2),
(39, 1072, 2),
(40, 1092, 2),
(41, 1121, 2),
(42, 1172, 2),
(43, 1197, 2),
(44, 1340, 2);

--
-- 限制导出的表
--

--
-- 限制表 `progress`
--
ALTER TABLE `progress`
  ADD CONSTRAINT `progress_role` FOREIGN KEY (`role`) REFERENCES `role` (`id`);

--
-- 限制表 `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `_order_id` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`);

--
-- 限制表 `role_right`
--
ALTER TABLE `role_right`
  ADD CONSTRAINT `right_role` FOREIGN KEY (`right_id`) REFERENCES `right` (`id`),
  ADD CONSTRAINT `role_right` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

--
-- 限制表 `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `role_user` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
  ADD CONSTRAINT `user_role` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
