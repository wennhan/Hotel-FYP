-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2023-12-17 15:37:04
-- 服务器版本： 10.4.32-MariaDB
-- PHP 版本： 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `hms`
--

-- --------------------------------------------------------

--
-- 表的结构 `attendence`
--

CREATE TABLE `attendence` (
  `serial` int(11) NOT NULL,
  `userId` varchar(10) NOT NULL,
  `date` date NOT NULL,
  `isAbsence` varchar(3) NOT NULL,
  `isLeave` varchar(3) NOT NULL,
  `remark` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 转存表中的数据 `attendence`
--

INSERT INTO `attendence` (`serial`, `userId`, `date`, `isAbsence`, `isLeave`, `remark`) VALUES
(13, 'U008', '2015-02-27', 'No', 'No', 'Self'),
(16, 'U009', '2015-04-18', 'No', 'No', 'Self'),
(17, 'U009', '2023-11-27', 'Yes', 'Yes', '123'),
(18, 'U0012', '2023-12-17', 'No', 'No', 'Self');

-- --------------------------------------------------------

--
-- 表的结构 `auto_id`
--

CREATE TABLE `auto_id` (
  `serial` int(11) NOT NULL,
  `prefix` varchar(10) NOT NULL,
  `number` int(11) NOT NULL,
  `description` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 转存表中的数据 `auto_id`
--

INSERT INTO `auto_id` (`serial`, `prefix`, `number`, `description`) VALUES
(1, 'UG', 1, 'User Group Id'),
(2, 'U', 14, 'User Id'),
(3, 'EMP', 7, 'Employee Id'),
(4, 'BL', 8, 'Block Id'),
(5, 'RM', 8, 'Room Number'),
(6, 'BIL', 12, 'Billing Id');

-- --------------------------------------------------------

--
-- 表的结构 `billing`
--

CREATE TABLE `billing` (
  `billId` varchar(10) NOT NULL,
  `type` varchar(50) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `billTo` varchar(80) NOT NULL,
  `billingDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 转存表中的数据 `billing`
--

INSERT INTO `billing` (`billId`, `type`, `amount`, `billTo`, `billingDate`) VALUES
('BIL007', 'Wifi', 300.00, 'U008', '2015-02-27'),
('BIL007', 'Tv', 60.00, 'U008', '2015-02-27'),
('BIL008', 'Wifi', 300.00, 'U009', '2015-02-27'),
('BIL009', 'Meal Cost Aprill', 2000.00, 'U009', '2015-04-17'),
('BIL009', 'Rent', 3000.00, 'U009', '2015-04-17'),
('BIL009', 'Wifi Net ', 500.00, 'U009', '2015-04-17'),
('BIL009', 'tv disc bill', 200.00, 'U009', '2015-04-17'),
('BIL009', 'Paper', 50.00, 'U009', '2015-04-17'),
('BIL009', 'Boishak Clelabration', 250.00, 'U009', '2015-04-17'),
('BIL0010', '123', 123.00, 'U0012', '2023-12-17'),
('BIL0011', 'Paper', 123.00, 'U009', '2023-12-17');

-- --------------------------------------------------------

--
-- 表的结构 `blocks`
--

CREATE TABLE `blocks` (
  `blockId` varchar(10) NOT NULL,
  `blockNo` varchar(10) NOT NULL,
  `blockName` varchar(30) NOT NULL,
  `description` varchar(80) NOT NULL,
  `isActive` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 转存表中的数据 `blocks`
--

INSERT INTO `blocks` (`blockId`, `blockNo`, `blockName`, `description`, `isActive`) VALUES
('BL004', 'BL-03', 'First Block', 'North Part Of the colony\"\"', 'Y'),
('BL006', 'BL-01', 'Third Block', '123', 'Y');

-- --------------------------------------------------------

--
-- 表的结构 `cost`
--

CREATE TABLE `cost` (
  `serial` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `date` date NOT NULL,
  `description` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 转存表中的数据 `cost`
--

INSERT INTO `cost` (`serial`, `type`, `amount`, `date`, `description`) VALUES
(4, 'Bazar', 2000.00, '2023-12-13', '2days Meal bazar'),
(5, 'Net bill', 5000.00, '2023-12-13', 'BTCL Internet Connection Bill'),
(6, 'Aircond', 50000.00, '2023-12-13', '123');

-- --------------------------------------------------------

--
-- 表的结构 `deposit`
--

CREATE TABLE `deposit` (
  `serial` int(11) NOT NULL,
  `userId` varchar(10) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `depositDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 转存表中的数据 `deposit`
--

INSERT INTO `deposit` (`serial`, `userId`, `amount`, `depositDate`) VALUES
(6, 'U008', 6000.00, '2015-02-27'),
(7, 'U009', 6000.00, '2023-12-13'),
(9, 'U008', 50000.00, '2023-12-13'),
(10, 'U0012', 50000.00, '2023-12-17'),
(11, 'U0012', 6000.00, '2023-12-17');

-- --------------------------------------------------------

--
-- 表的结构 `employee`
--

CREATE TABLE `employee` (
  `serial` int(11) NOT NULL,
  `empId` varchar(10) NOT NULL,
  `userGroupId` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `empType` varchar(50) NOT NULL,
  `gender` varchar(10) NOT NULL,
  `dob` date NOT NULL,
  `cellNo` varchar(15) NOT NULL,
  `address` varchar(150) NOT NULL,
  `doj` date NOT NULL,
  `designation` varchar(50) NOT NULL,
  `salary` decimal(18,2) NOT NULL,
  `blockNo` varchar(10) NOT NULL,
  `isActive` varchar(1) NOT NULL,
  `perPhoto` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 转存表中的数据 `employee`
--

INSERT INTO `employee` (`serial`, `empId`, `userGroupId`, `name`, `empType`, `gender`, `dob`, `cellNo`, `address`, `doj`, `designation`, `salary`, `blockNo`, `isActive`, `perPhoto`) VALUES
(1, 'EMP003', 'UG003', 'HoDuiNuel', 'Care Taker', 'Male', '1995-06-20', '01710123456', ' Dhanmoni,Dahaka-1207', '2015-02-11', 'Asistant Care', 5000.00, 'BL-01', 'Y', 'EMP003.jpg'),
(2, 'EMP004', 'UG003', 'MasterChef', 'Cook', 'Female', '1994-06-14', '01720123456', ' Shukrabad-1207', '2015-01-27', 'Cook', 5000.00, 'BL-01', 'Y', 'EMP004.jpeg'),
(6, 'EMP006', 'UG003', 'ChyeWennHan', '123', 'Male', '2023-12-17', '123', ' 123', '2023-12-17', '123', 123.00, '123', 'N', 'EMP006.png');

-- --------------------------------------------------------

--
-- 表的结构 `feesinfo`
--

CREATE TABLE `feesinfo` (
  `serial` int(11) NOT NULL,
  `type` varchar(80) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `amount` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 转存表中的数据 `feesinfo`
--

INSERT INTO `feesinfo` (`serial`, `type`, `description`, `amount`) VALUES
(9, 'Wifi', 'internet charge', 300.00),
(10, 'TV', 'Television', 60.00),
(12, 'Aircond', 'aircond maintain', 300.00);

-- --------------------------------------------------------

-- 表的结构 `meal`

CREATE TABLE `meal` (
  `serial` int(11) NOT NULL,
  `userId` varchar(10) NOT NULL,
  `photo` varchar(255),
  `title` varchar(255),
  `unitPrice` decimal(10,2),
  `status` varchar(10),
  `noOfMeal` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;


-- 转存表中的数据 `meal`

INSERT INTO `meal` (`serial`, `userId`, `photo`, `title`, `unitPrice`, `status`, `noOfMeal`, `date`) VALUES
(1, 'U008', 'meal1.png', 'Meal 1', 5.99, 'Active', 2, '2015-02-27'),
(2, 'U008', 'meal2.png', 'Meal 2', 7.99, 'Active', 2, '2015-04-17');



-- 表的结构 `cart`
CREATE TABLE `cart` (
  `serial` int(11) NOT NULL,
  `userId` varchar(10) NOT NULL,
  `mealId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `totalPayment` decimal(10,2),
  `date` date
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- 转存表中的数据 `cart`
INSERT INTO `cart` (`serial`, `userId`, `mealId`, `quantity`, `totalPayment`, `date`) VALUES
(1, 'U008', 1, 1, 11.99,  '2023-12-18'),
(2, 'U008', 2, 2, 23.50, '2023-12-18');

-- --------------------------------------------------------

-- 表的结构 `orderpayment`
CREATE TABLE `orderpayment` (
  `serial` int(11) NOT NULL,
  `userId` varchar(10) NOT NULL,
  `mealId` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `totalPayment` decimal(10,2),
  `status` varchar(10) NOT NULL,
  `date` date
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- 转存表中的数据 `orderpayment`
INSERT INTO `orderpayment` (`serial`, `userId`, `mealId`, `status`,`quantity`, `totalPayment`, `date`) VALUES
(1, 'U008',  1, 'Pending',1, 11.99, '2023-12-18'),
(2, 'U008',  2, 'Done', 1,23.50, '2023-12-18');


-- --------------------------------------------------------


--
-- 表的结构 `mealrate`
--

CREATE TABLE `mealrate` (
  `rate` decimal(18,2) NOT NULL,
  `note` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 转存表中的数据 `mealrate`
--

INSERT INTO `mealrate` (`rate`, `note`) VALUES
(80.00, 'Feb,2015'),
(123.00, '123');

-- --------------------------------------------------------

--
-- 表的结构 `notice`
--

CREATE TABLE `notice` (
  `serial` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` varchar(500) NOT NULL,
  `createdDate` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 转存表中的数据 `notice`
--

INSERT INTO `notice` (`serial`, `title`, `description`, `createdDate`) VALUES
(6, '21st February Celebration123', '21st February Celebration,rali,etc', '2023-12-17 11:25:22'),
(7, 'Happy New Year 2015', 'Happy New Year', '2015-02-27 15:35:25'),
(9, '	Happy New Year', '	Happy New Year', '2023-12-17 11:53:44');

-- --------------------------------------------------------

--
-- 表的结构 `payment`
--

CREATE TABLE `payment` (
  `serial` int(11) NOT NULL,
  `description` varchar(100) NOT NULL,
  `paymentTo` varchar(100) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `paymentBy` varchar(50) NOT NULL,
  `paymentDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 转存表中的数据 `payment`
--

INSERT INTO `payment` (`serial`, `description`, `paymentTo`, `amount`, `paymentBy`, `paymentDate`) VALUES
(3, 'Paper Bill', 'Civickun', 500.00, 'Cash', '2015-02-27');

-- --------------------------------------------------------

--
-- 表的结构 `rooms`
--

CREATE TABLE `rooms` (
  `roomId` varchar(10) NOT NULL,
  `roomNo` varchar(20) NOT NULL,
  `blockId` varchar(10) NOT NULL,
  `noOfSeat` int(11) NOT NULL,
  `description` varchar(50) DEFAULT NULL,
  `isActive` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 转存表中的数据 `rooms`
--

INSERT INTO `rooms` (`roomId`, `roomNo`, `blockId`, `noOfSeat`, `description`, `isActive`) VALUES
('RM004', 'R-01', 'BL-01', 4, 'Block-01(North)', 'Y'),
('RM006', 'R-02', 'BL-01', 2, 'Block-01(North)', 'Y'),
('RM007', 'R-03', 'BL-02', 4, 'Block-02(West)', 'Y');

-- --------------------------------------------------------

--
-- 表的结构 `salary`
--

CREATE TABLE `salary` (
  `serial` int(11) NOT NULL,
  `empId` varchar(10) NOT NULL,
  `monthYear` varchar(30) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `addedDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 转存表中的数据 `salary`
--

INSERT INTO `salary` (`serial`, `empId`, `monthYear`, `amount`, `addedDate`) VALUES
(5, 'EMP004', 'February-2015', 5000.00, '2015-02-27'),
(7, 'EMP003', 'May-2023', 50000.00, '2023-12-16'),
(9, 'EMP004', 'February-2023', 6000.00, '2023-12-16');

-- --------------------------------------------------------

--
-- 表的结构 `seataloc`
--

CREATE TABLE `seataloc` (
  `userId` varchar(10) NOT NULL,
  `roomNo` varchar(10) NOT NULL,
  `blockNo` varchar(30) NOT NULL,
  `monthlyRent` decimal(18,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 转存表中的数据 `seataloc`
--

INSERT INTO `seataloc` (`userId`, `roomNo`, `blockNo`, `monthlyRent`) VALUES
('U008', 'R-01', 'BL-01', 32000.00),
('U009', 'R-02', 'BL-01', 7500.00);

-- --------------------------------------------------------

--
-- 表的结构 `stdpayment`
--

CREATE TABLE `stdpayment` (
  `serial` int(11) NOT NULL,
  `userId` varchar(10) NOT NULL,
  `paymentBy` varchar(50) NOT NULL,
  `transNo` varchar(50) NOT NULL,
  `amount` decimal(18,2) NOT NULL,
  `transDate` date NOT NULL,
  `remark` varchar(50) NOT NULL,
  `status` varchar(10),
  `isApprove` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 转存表中的数据 `stdpayment`
--

INSERT INTO `stdpayment` (`serial`, `userId`, `paymentBy`, `transNo`, `amount`, `transDate`, `remark`,`status`, `isApprove`) VALUES
(3, 'U008', 'DBBL', '+8801755305154', 6000.00, '2015-02-26', 'Feb,2015 Bill', 'Paid', 'Yes'),
(4, 'U009', 'Bank', 'DD-4556', 5500.00, '2015-02-27', 'test', 'Paid','Yes'),
(5, 'U009', 'Bkash', '0185236974', 6000.00, '2015-04-17', 'all cost rent meal,net,tv','Paid', 'Yes'),
(7, 'U0012', 'Bank', '0182818612', 50000.00, '2023-12-22', '123','Paid', 'Yes'),
(8, 'U0012', 'Bank', '0182818612', 123.00, '2023-12-17', 'test', 'Paid','Yes'),
(9, 'U0012', 'Bkash', '0182818612', 12333.00, '2023-12-08', 'test','Unpaid', 'No');

-- --------------------------------------------------------

--
-- 表的结构 `studentinfo`
--

CREATE TABLE `studentinfo` (
  `serial` int(11) NOT NULL,
  `userId` varchar(10) NOT NULL,
  `userGroupId` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `studentId` varchar(15) NOT NULL,
  `cellNo` varchar(15) NOT NULL,
  `email` varchar(80) NOT NULL,
  `nameOfInst` varchar(100) NOT NULL,
  `program` varchar(80) NOT NULL,
  `batchNo` varchar(10) NOT NULL,
  `gender` varchar(8) NOT NULL,
  `dob` date NOT NULL,
  `bloodGroup` varchar(5) NOT NULL,
  `nationality` varchar(30) NOT NULL,
  `nationalId` varchar(20) DEFAULT NULL,
  `passportNo` varchar(20) DEFAULT NULL,
  `fatherName` varchar(50) NOT NULL,
  `motherName` varchar(50) NOT NULL,
  `fatherCellNo` varchar(15) NOT NULL,
  `motherCellNo` varchar(15) NOT NULL,
  `localGuardian` varchar(50) NOT NULL,
  `localGuardianCell` varchar(15) NOT NULL,
  `presentAddress` varchar(150) NOT NULL,
  `parmanentAddress` varchar(150) NOT NULL,
  `perPhoto` varchar(20) NOT NULL,
  `admitDate` date NOT NULL,
  `isActive` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 转存表中的数据 `studentinfo`
--

INSERT INTO `studentinfo` (`serial`, `userId`, `userGroupId`, `name`, `studentId`, `cellNo`, `email`, `nameOfInst`, `program`, `batchNo`, `gender`, `dob`, `bloodGroup`, `nationality`, `nationalId`, `passportNo`, `fatherName`, `motherName`, `fatherCellNo`, `motherCellNo`, `localGuardian`, `localGuardianCell`, `presentAddress`, `parmanentAddress`, `perPhoto`, `admitDate`, `isActive`) VALUES
(10, 'U0012', 'UG004', 'ChyeWennHan', 'wennhan', '01832ad', 'chyewennhan@gmail.com', 'asd', 'as', '12341', 'Male', '2023-12-07', 'O(un)', 'China', '123', '123', '123', '123', '123', '123', '123', '123', ' 123  ', '123', 'U0012.jpg', '2023-12-13', 'Y'),
(8, 'U008', 'UG004', 'michealJohnson', '151-15-1155', '+8801755000002', 'rasel@gmail.com', 'DIU', 'CSE', '34', 'Male', '1994-06-14', 'AB(+)', 'Bangladeshi', 'N/A', 'N/A', 'Mr. Father', '+8801722000000', 'Mst. Mother', '+8801722000005', 'Mr. Local Boy', '+8801722000001', ' Dhanmondi,Dhaka-1207 ', 'Dhanmondi,Dhaka-1207', 'U008.jpg', '2015-02-27', 'Y'),
(9, 'EMP003', 'UG004', 'frerauhui', '151-15-1122', '+881722545660', 'zahidul@gmail.com', 'DIU', 'CSE', '34', 'Male', '2005-07-13', 'O(+)', 'Bangladeshi', 'N/A', 'N/A', 'Mr. Father', 'Mst Mother', '+8801710565958', '+8801710565958', 'Mr Local boy', '+8801710565960', ' Dhanmondi,Dhaka-1207', ' Dhanmondi,Dhaka-1207', 'U009.jpg', '2015-02-27', 'Y');

-- --------------------------------------------------------

--
-- 表的结构 `timeset`
--

CREATE TABLE `timeset` (
  `inTime` varchar(15) NOT NULL,
  `outTime` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 转存表中的数据 `timeset`
--

INSERT INTO `timeset` (`inTime`, `outTime`) VALUES
('07:00 PM', '06:00 AM'),
('06:00 AM', '12:00 AM');

-- --------------------------------------------------------

--
-- 表的结构 `usergroup`
--

CREATE TABLE `usergroup` (
  `serial` int(11) NOT NULL,
  `id` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 转存表中的数据 `usergroup`
--

INSERT INTO `usergroup` (`serial`, `id`, `name`, `description`) VALUES
(1, 'UG001', 'Admin', 'Admin group'),
(2, 'UG004', 'Student', 'Students Group'),
(4, 'UG002', 'Supervisor', 'Hostel supervisor'),
(5, 'UG003', 'Employee', 'Employe Group');

-- --------------------------------------------------------

--
-- 表的结构 `users`
--

CREATE TABLE `users` (
  `serial` int(11) NOT NULL,
  `userId` varchar(10) NOT NULL,
  `userGroupId` varchar(10) NOT NULL,
  `name` varchar(100) NOT NULL,
  `loginId` varchar(150) NOT NULL,
  `password` varchar(50) NOT NULL,
  `verifyCode` varchar(10) NOT NULL,
  `expireDate` date NOT NULL,
  `isVerifed` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- 转存表中的数据 `users`
--

INSERT INTO `users` (`serial`, `userId`, `userGroupId`, `name`, `loginId`, `password`, `verifyCode`, `expireDate`, `isVerifed`) VALUES
(10, 'U008', 'UG004', 'michealJohnson', 'michealJohnson', '1efcf825d090a4cffb33c3c5238610bb', 'vhms2115', '2115-01-04', 'Y'),
(14, 'EMP003', 'UG003', 'frerauhui', 'frerauhui', '1efcf825d090a4cffb33c3c5238610bb', 'vhms2115', '2115-01-04', 'Y'),
(16, 'U0012', 'UG004', 'ChyeWennHan', 'wennhan', '1efcf825d090a4cffb33c3c5238610bb', 'vhms2115', '2115-01-04', 'Y'),
(19, 'U0013', 'UG001', '123', 'admin', '1efcf825d090a4cffb33c3c5238610bb', 'vhms2115', '2115-01-04', 'Y');

--
-- 转储表的索引
--

--
-- 表的索引 `attendence`
--
ALTER TABLE `attendence`
  ADD PRIMARY KEY (`serial`),
  ADD UNIQUE KEY `serial` (`serial`);

--
-- 表的索引 `auto_id`
--
ALTER TABLE `auto_id`
  ADD UNIQUE KEY `serial` (`serial`);

--
-- 表的索引 `blocks`
--
ALTER TABLE `blocks`
  ADD PRIMARY KEY (`blockId`),
  ADD UNIQUE KEY `blockId` (`blockId`);

--
-- 表的索引 `cost`
--
ALTER TABLE `cost`
  ADD PRIMARY KEY (`serial`);

--
-- 表的索引 `deposit`
--
ALTER TABLE `deposit`
  ADD PRIMARY KEY (`serial`);

--
-- 表的索引 `employee`
--
ALTER TABLE `employee`
  ADD PRIMARY KEY (`empId`),
  ADD UNIQUE KEY `serial` (`serial`),
  ADD UNIQUE KEY `cellNo` (`cellNo`);

--
-- 表的索引 `feesinfo`
--
ALTER TABLE `feesinfo`
  ADD PRIMARY KEY (`serial`);


--
-- 使用表AUTO_INCREMENT `meal`
--
ALTER TABLE `meal`
  ADD PRIMARY KEY (`serial`);


--
-- 使用表AUTO_INCREMENT `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`serial`);



--
-- 使用表AUTO_INCREMENT `orderpayment`
--
ALTER TABLE `orderpayment`
  ADD PRIMARY KEY (`serial`);



--
-- 表的索引 `notice`
--
ALTER TABLE `notice`
  ADD PRIMARY KEY (`serial`),
  ADD UNIQUE KEY `serial` (`serial`);

--
-- 表的索引 `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`serial`);

--
-- 表的索引 `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`roomId`);

--
-- 表的索引 `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`serial`);

--
-- 表的索引 `seataloc`
--
ALTER TABLE `seataloc`
  ADD PRIMARY KEY (`userId`);

--
-- 表的索引 `stdpayment`
--
ALTER TABLE `stdpayment`
  ADD PRIMARY KEY (`serial`);

--
-- 表的索引 `studentinfo`
--
ALTER TABLE `studentinfo`
  ADD PRIMARY KEY (`userId`,`serial`),
  ADD UNIQUE KEY `serial` (`serial`),
  ADD UNIQUE KEY `userId` (`userId`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cellNo` (`cellNo`);

--
-- 表的索引 `usergroup`
--
ALTER TABLE `usergroup`
  ADD UNIQUE KEY `serial` (`serial`),
  ADD UNIQUE KEY `id` (`id`);

--
-- 表的索引 `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`serial`),
  ADD UNIQUE KEY `serial` (`serial`),
  ADD UNIQUE KEY `serial_2` (`serial`),
  ADD UNIQUE KEY `serial_3` (`serial`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `attendence`
--
ALTER TABLE `attendence`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- 使用表AUTO_INCREMENT `auto_id`
--
ALTER TABLE `auto_id`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `cost`
--
ALTER TABLE `cost`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- 使用表AUTO_INCREMENT `deposit`
--
ALTER TABLE `deposit`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- 使用表AUTO_INCREMENT `employee`
--
ALTER TABLE `employee`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- 使用表AUTO_INCREMENT `feesinfo`
--
ALTER TABLE `feesinfo`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

-- meal
ALTER TABLE `meal`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT=13;


-- cart
ALTER TABLE `cart`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT=25;


-- orderpayment
ALTER TABLE `orderpayment`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT=55;


--
-- 使用表AUTO_INCREMENT `notice`
--
ALTER TABLE `notice`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `payment`
--
ALTER TABLE `payment`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- 使用表AUTO_INCREMENT `salary`
--
ALTER TABLE `salary`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `stdpayment`
--
ALTER TABLE `stdpayment`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `studentinfo`
--
ALTER TABLE `studentinfo`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 使用表AUTO_INCREMENT `usergroup`
--
ALTER TABLE `usergroup`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- 使用表AUTO_INCREMENT `users`
--
ALTER TABLE `users`
  MODIFY `serial` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
