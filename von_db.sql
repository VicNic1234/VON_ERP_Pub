-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2024 at 10:18 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `von_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `accessurl`
--

CREATE TABLE `accessurl` (
  `id` int(11) NOT NULL,
  `deptID` int(11) NOT NULL,
  `URL` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `accountinvoice`
--

CREATE TABLE `accountinvoice` (
  `aid` int(11) NOT NULL,
  `logID` int(11) NOT NULL,
  `POID` text NOT NULL,
  `SetForIn` int(11) NOT NULL,
  `SetForInBy` int(11) NOT NULL,
  `PreAcc` int(11) NOT NULL,
  `PostAcc` int(11) NOT NULL,
  `RecPay` int(11) NOT NULL,
  `OEMID` varchar(11) NOT NULL,
  `CUSID` varchar(11) NOT NULL,
  `UnitRate` varchar(30) NOT NULL,
  `POAmt` varchar(30) NOT NULL,
  `Qty` int(11) NOT NULL,
  `PODiscount` varchar(20) NOT NULL,
  `DiscountPercent` varchar(25) NOT NULL,
  `POComment` text NOT NULL,
  `DueDate` varchar(22) NOT NULL,
  `Description` text NOT NULL,
  `MartServNo` varchar(60) NOT NULL,
  `UOM` varchar(24) NOT NULL,
  `Currency` varchar(12) NOT NULL,
  `UnitWeight` varchar(12) NOT NULL,
  `ExWeight` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `acct_ivitems`
--

CREATE TABLE `acct_ivitems` (
  `poitid` int(11) NOT NULL,
  `PONo` varchar(60) NOT NULL,
  `PDFNUM` text NOT NULL,
  `PDFItemID` int(4) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `description` text NOT NULL,
  `units` varchar(40) NOT NULL,
  `qty` varchar(10) NOT NULL,
  `unitprice` varchar(10) NOT NULL,
  `CreatedOn` varchar(30) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `PostedOn` varchar(30) NOT NULL,
  `PostID` int(6) NOT NULL,
  `ItemGL` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `acct_ivmiscellaneous`
--

CREATE TABLE `acct_ivmiscellaneous` (
  `poitid` int(11) NOT NULL,
  `PONo` varchar(60) NOT NULL,
  `PDFNUM` text NOT NULL,
  `Impact` varchar(10) NOT NULL,
  `AmtType` varchar(30) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `description` text NOT NULL,
  `units` varchar(40) NOT NULL,
  `qty` varchar(10) NOT NULL,
  `price` varchar(10) NOT NULL,
  `CreatedOn` varchar(30) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `PostedOn` varchar(30) NOT NULL,
  `PostID` int(6) NOT NULL,
  `ItemGL` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `acct_vendorsinvoices`
--

CREATE TABLE `acct_vendorsinvoices` (
  `cid` int(11) NOT NULL,
  `IVNo` text NOT NULL,
  `Comment` text NOT NULL,
  `conDiv` int(2) NOT NULL,
  `IVDate` varchar(40) NOT NULL,
  `ENLATTN` int(4) NOT NULL,
  `VENATTN` text NOT NULL,
  `VendSource` int(3) NOT NULL,
  `ScopeOfSW` text NOT NULL,
  `RaisedBy` int(2) NOT NULL,
  `RaisedOn` varchar(30) NOT NULL,
  `FileLink` text NOT NULL,
  `Currency` varchar(10) NOT NULL,
  `PDFNUM` varchar(70) NOT NULL,
  `PONUM` text NOT NULL,
  `LegalOfficer` int(2) NOT NULL,
  `LegalOfficerComment` text NOT NULL,
  `LegalOfficerOn` varchar(60) NOT NULL,
  `GMCSAppDate` varchar(30) NOT NULL,
  `GMCSAppComment` text NOT NULL,
  `GMCSApp` int(5) NOT NULL,
  `AllowDD` int(11) NOT NULL DEFAULT 0,
  `DDOfficer` int(2) NOT NULL,
  `DDOfficerComment` text NOT NULL,
  `DDOfficerOn` varchar(60) NOT NULL,
  `MDOffice` int(2) NOT NULL,
  `MDOfficeComment` text NOT NULL,
  `MDOfficeOn` varchar(60) NOT NULL,
  `AccountOfficer` int(2) NOT NULL,
  `AccountOfficerComment` text NOT NULL,
  `AccountOfficerOn` varchar(60) NOT NULL,
  `SETR` int(2) NOT NULL DEFAULT 0,
  `SERLog` text NOT NULL,
  `isActive` int(2) NOT NULL DEFAULT 1,
  `NGNRate` varchar(30) NOT NULL,
  `BnkID` int(4) NOT NULL,
  `CRDGL` varchar(10) NOT NULL,
  `PostedOn` varchar(30) NOT NULL,
  `PostID` int(5) NOT NULL,
  `PostedBy` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='0';

-- --------------------------------------------------------

--
-- Table structure for table `acc_chart_class`
--

CREATE TABLE `acc_chart_class` (
  `cid` int(3) NOT NULL,
  `class_name` varchar(60) NOT NULL DEFAULT '',
  `ctype` tinyint(1) NOT NULL DEFAULT 0,
  `nature` varchar(3) NOT NULL,
  `balance` varchar(8) NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `acc_chart_master`
--

CREATE TABLE `acc_chart_master` (
  `account_code` varchar(11) NOT NULL,
  `account_code2` varchar(15) NOT NULL DEFAULT '',
  `account_name` varchar(60) NOT NULL DEFAULT '',
  `account_type` varchar(10) NOT NULL DEFAULT '0',
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `mid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `acc_chart_types`
--

CREATE TABLE `acc_chart_types` (
  `id` int(10) NOT NULL,
  `name` varchar(60) NOT NULL DEFAULT '',
  `class_id` varchar(3) NOT NULL DEFAULT '',
  `parent` varchar(10) NOT NULL DEFAULT '-1',
  `isActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `acc_settings`
--

CREATE TABLE `acc_settings` (
  `id` int(11) NOT NULL,
  `variable` varchar(60) NOT NULL,
  `value` text NOT NULL,
  `valueID` int(11) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `appuser`
--

CREATE TABLE `appuser` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `username` varchar(70) NOT NULL,
  `password` varchar(70) NOT NULL,
  `email` varchar(70) NOT NULL,
  `createdon` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `createdby` int(11) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auditlog`
--

CREATE TABLE `auditlog` (
  `id` int(11) NOT NULL,
  `logtype` varchar(30) NOT NULL,
  `user` int(6) NOT NULL,
  `logdate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `systemID` text NOT NULL,
  `logaction` text NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bankaccount`
--

CREATE TABLE `bankaccount` (
  `baccid` int(11) NOT NULL,
  `description` text NOT NULL,
  `acctnum` varchar(24) NOT NULL,
  `acctnme` text NOT NULL,
  `sortcode` varchar(15) NOT NULL,
  `currency` int(5) NOT NULL,
  `bnkname` text NOT NULL,
  `bnkaddress` text NOT NULL,
  `GLAcct` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bankpayment`
--

CREATE TABLE `bankpayment` (
  `siid` int(11) NOT NULL,
  `TrancID` int(11) NOT NULL,
  `InvoiceNo` varchar(60) NOT NULL,
  `ChequeNo` varchar(60) NOT NULL,
  `VendorCode` varchar(60) NOT NULL,
  `TransAmt` varchar(50) NOT NULL,
  `TransDate` varchar(50) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `AuditLog` text NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 1,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `banks`
--

CREATE TABLE `banks` (
  `id` int(11) NOT NULL,
  `name` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `budget_expected`
--

CREATE TABLE `budget_expected` (
  `deid` int(11) NOT NULL,
  `year` varchar(3) NOT NULL,
  `month` varchar(6) NOT NULL,
  `division` int(4) NOT NULL,
  `amount` int(11) NOT NULL,
  `createdon` varchar(32) NOT NULL,
  `createdby` int(2) NOT NULL,
  `isActive` int(2) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `businessunit`
--

CREATE TABLE `businessunit` (
  `id` int(11) NOT NULL,
  `DeptID` int(6) NOT NULL,
  `BussinessUnit` varchar(40) NOT NULL,
  `Descript` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `calibration_log`
--

CREATE TABLE `calibration_log` (
  `calid` int(11) NOT NULL,
  `equipid` int(6) NOT NULL,
  `calibratedby` int(11) NOT NULL,
  `calibratedon` varchar(30) NOT NULL,
  `analysisby` text NOT NULL,
  `duedate` varchar(30) NOT NULL,
  `comment` text NOT NULL,
  `recdate` varchar(30) NOT NULL,
  `recby` int(4) NOT NULL,
  `AuditLog` text NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cashreq`
--

CREATE TABLE `cashreq` (
  `reqid` int(11) NOT NULL,
  `isActive` int(3) NOT NULL DEFAULT 1,
  `DeletedBy` int(7) NOT NULL,
  `DeletedOn` varchar(30) NOT NULL,
  `fDeletedBy` int(7) NOT NULL,
  `fDeletedOn` varchar(30) NOT NULL,
  `Curr` varchar(6) NOT NULL,
  `staffName` varchar(120) NOT NULL,
  `staffID` int(11) NOT NULL,
  `RequestDate` varchar(26) NOT NULL,
  `RequestID` text NOT NULL,
  `Deparment` varchar(60) NOT NULL,
  `ItemDes` text NOT NULL,
  `Purpose` text NOT NULL,
  `Amount` varchar(60) NOT NULL,
  `Qty` varchar(30) NOT NULL,
  `relatedPDF` varchar(40) NOT NULL,
  `Stage` varchar(60) NOT NULL,
  `LastActor` text NOT NULL,
  `UserApp` int(3) NOT NULL DEFAULT 0,
  `UserAppDate` varchar(60) NOT NULL,
  `UserAppComment` text NOT NULL,
  `SupervisorApp` int(6) NOT NULL,
  `SupervisorAppDate` varchar(40) NOT NULL,
  `SupervisorComment` text NOT NULL,
  `DeptHeadApp` int(2) NOT NULL DEFAULT 0,
  `DeptHeadAppDate` varchar(60) NOT NULL,
  `DeptHeadAppComment` text NOT NULL,
  `DivHeadApp` int(2) NOT NULL DEFAULT 0,
  `DivHeadAppDate` varchar(60) NOT NULL,
  `DivHeadAppComment` text NOT NULL,
  `MgrApp` int(2) NOT NULL DEFAULT 0,
  `MgrAppDate` varchar(60) NOT NULL,
  `MgrAppComment` text NOT NULL,
  `DDApp` int(2) NOT NULL,
  `DDAppDate` varchar(60) NOT NULL,
  `DDAppComment` text NOT NULL,
  `COOApp` int(11) NOT NULL,
  `COOAppDate` varchar(32) NOT NULL,
  `COOComment` text NOT NULL,
  `DDOfficerApp` int(5) NOT NULL,
  `DDOfficerAppDate` varchar(37) NOT NULL,
  `DDOfficerAppComment` text NOT NULL,
  `MDApp` int(3) NOT NULL,
  `MDAppDate` varchar(40) NOT NULL,
  `MDComment` text NOT NULL,
  `SetForPaymentOn` varchar(30) NOT NULL,
  `SetForPaymentBy` int(5) NOT NULL,
  `PostedBy` int(5) NOT NULL,
  `PostID` varchar(10) NOT NULL,
  `PostedOn` varchar(30) NOT NULL,
  `Approved` int(11) NOT NULL DEFAULT 0,
  `ApprovedAmount` varchar(30) NOT NULL,
  `ApprovedBy` varchar(60) NOT NULL,
  `ApprovedDate` varchar(30) NOT NULL,
  `attachment` text NOT NULL,
  `Status` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cheuqes`
--

CREATE TABLE `cheuqes` (
  `chid` int(11) NOT NULL,
  `cheuqeNME` text NOT NULL,
  `Bank` text NOT NULL,
  `Amt` text NOT NULL,
  `TDate` varchar(35) NOT NULL,
  `CreatedBy` int(2) NOT NULL,
  `CreatedOn` varchar(30) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `compcontri_settings`
--

CREATE TABLE `compcontri_settings` (
  `id` int(11) NOT NULL,
  `Description` varchar(200) NOT NULL,
  `CalMethod` int(3) NOT NULL,
  `AppliedToStaffGroup` int(11) NOT NULL,
  `EarningFrequ` int(3) NOT NULL,
  `GLMaster` int(6) NOT NULL,
  `Taxable` int(3) NOT NULL DEFAULT 1,
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contracts`
--

CREATE TABLE `contracts` (
  `cid` int(11) NOT NULL,
  `ContractNo` text NOT NULL,
  `Comment` text NOT NULL,
  `conDiv` int(2) NOT NULL,
  `conSDate` varchar(40) NOT NULL,
  `conEDate` varchar(40) NOT NULL,
  `VendSource` int(3) NOT NULL,
  `RaisedBy` int(2) NOT NULL,
  `RaisedOn` int(2) NOT NULL,
  `FileLink` text NOT NULL,
  `Currency` varchar(10) NOT NULL,
  `PDFNUM` varchar(70) NOT NULL,
  `TotalSum` text NOT NULL,
  `AllowMD` int(11) NOT NULL DEFAULT 0,
  `SERLog` text NOT NULL,
  `LegalOfficer` int(2) NOT NULL,
  `LegalOfficerComment` text NOT NULL,
  `LegalOfficerOn` varchar(60) NOT NULL,
  `DDOfficer` int(2) NOT NULL,
  `DDOfficerComment` text NOT NULL,
  `DDOfficerOn` varchar(60) NOT NULL,
  `MDOffice` int(2) NOT NULL,
  `MDOfficeComment` text NOT NULL,
  `MDOfficeOn` varchar(60) NOT NULL,
  `AccountOfficer` int(2) NOT NULL,
  `AccountOfficerComment` text NOT NULL,
  `AccountOfficerOn` varchar(60) NOT NULL,
  `isActivate` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='0';

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `country_code` varchar(2) NOT NULL DEFAULT '',
  `country_name` varchar(100) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `crmlitfeedback`
--

CREATE TABLE `crmlitfeedback` (
  `crmLITfbID` int(11) NOT NULL,
  `LineItemID` int(11) NOT NULL,
  `Msg` text NOT NULL,
  `FromCRM` varchar(4) NOT NULL,
  `ToCRM` varchar(4) NOT NULL,
  `Attachment` text NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `CreatedBy` int(11) NOT NULL,
  `isActive` int(3) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `curID` int(11) NOT NULL,
  `Abbreviation` varchar(10) NOT NULL,
  `Symbol` varchar(5) NOT NULL,
  `CurrencyName` varchar(50) NOT NULL,
  `HunderthName` varchar(50) NOT NULL,
  `Country` varchar(50) NOT NULL,
  `AutoUpdate` int(11) DEFAULT 0,
  `ReportingCurreny` int(2) DEFAULT 0,
  `ExRateToNaria` varchar(50) NOT NULL,
  `ExRateToUSD` varchar(30) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cuspo`
--

CREATE TABLE `cuspo` (
  `CUSPOid` int(11) NOT NULL,
  `PONum` text NOT NULL,
  `MirriorPO` text NOT NULL,
  `CorContract` text NOT NULL,
  `CorRFQ` text NOT NULL,
  `RFQUpdate` text NOT NULL,
  `Status` varchar(40) DEFAULT NULL,
  `Customer` varchar(60) NOT NULL,
  `cusid` int(11) NOT NULL,
  `Attention` text NOT NULL,
  `Scope` varchar(15) NOT NULL,
  `DateStart` varchar(30) NOT NULL,
  `DateEnd` varchar(30) NOT NULL,
  `Source` varchar(10) NOT NULL,
  `Currency` varchar(30) NOT NULL,
  `Attachment` text NOT NULL,
  `CompanyRefNo` varchar(20) NOT NULL,
  `PENjobCode` varchar(30) NOT NULL,
  `BuyersNme` varchar(60) NOT NULL,
  `PEAssignee` varchar(60) NOT NULL,
  `PEAID` varchar(10) NOT NULL,
  `CreatedOn` varchar(60) NOT NULL,
  `RFQBusUnit` int(5) NOT NULL,
  `NoLinIems` varchar(10) NOT NULL,
  `Comment` text NOT NULL,
  `Ellapes` varchar(10) NOT NULL,
  `OnTQ` int(11) NOT NULL DEFAULT 0,
  `OnTQBy` int(3) NOT NULL,
  `OnTQOn` varchar(30) NOT NULL,
  `DateCreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `cusid` int(11) NOT NULL,
  `CustormerNme` varchar(60) NOT NULL,
  `cussnme` varchar(6) NOT NULL,
  `CusRefNo` varchar(60) NOT NULL,
  `CusAddress` text NOT NULL,
  `CusAddress2` text NOT NULL,
  `CusLogo` longblob NOT NULL,
  `CusPhone` varchar(24) NOT NULL,
  `CusPhone1` varchar(24) NOT NULL,
  `CusPhone2` varchar(24) NOT NULL,
  `CusEmail1` text NOT NULL,
  `CusEmail2` text NOT NULL,
  `CusNme1` text NOT NULL,
  `CusNme2` text NOT NULL,
  `webaddress` text NOT NULL,
  `email` text NOT NULL,
  `VendorCode` varchar(60) NOT NULL,
  `InvoiceAdd` text NOT NULL,
  `BusinessUnit` varchar(5) NOT NULL,
  `Category` text NOT NULL,
  `createdby` varchar(5) NOT NULL,
  `updatedby` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `deductions_settings`
--

CREATE TABLE `deductions_settings` (
  `id` int(11) NOT NULL,
  `Description` varchar(200) NOT NULL,
  `CalMethod` int(3) NOT NULL,
  `AppliedToStaffGroup` int(11) NOT NULL,
  `EarningFrequ` int(3) NOT NULL,
  `GLMaster` int(6) NOT NULL,
  `Taxable` int(3) NOT NULL DEFAULT 1,
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `id` int(11) NOT NULL,
  `DeptmentName` varchar(60) NOT NULL,
  `DeptCode` varchar(50) NOT NULL,
  `DivID` int(11) NOT NULL,
  `BusinessUnitID` int(3) NOT NULL,
  `Description` text NOT NULL,
  `hod` int(11) NOT NULL,
  `supervisor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `divisions`
--

CREATE TABLE `divisions` (
  `divid` int(11) NOT NULL,
  `DivisionName` varchar(40) NOT NULL,
  `GM` int(3) NOT NULL,
  `DH` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dmcuspo`
--

CREATE TABLE `dmcuspo` (
  `CUSPOid` int(11) NOT NULL,
  `PONum` text NOT NULL,
  `MirriorPO` text NOT NULL,
  `CorContract` text NOT NULL,
  `CorRFQ` text NOT NULL,
  `RFQUpdate` text NOT NULL,
  `Status` varchar(40) DEFAULT NULL,
  `Customer` varchar(60) NOT NULL,
  `cusid` int(11) NOT NULL,
  `Attention` text NOT NULL,
  `Scope` varchar(15) NOT NULL,
  `DateStart` varchar(30) NOT NULL,
  `DateEnd` varchar(30) NOT NULL,
  `Source` varchar(10) NOT NULL,
  `Currency` varchar(30) NOT NULL,
  `Attachment` text NOT NULL,
  `CompanyRefNo` varchar(20) NOT NULL,
  `PENjobCode` varchar(30) NOT NULL,
  `BuyersNme` varchar(60) NOT NULL,
  `PEAssignee` varchar(60) NOT NULL,
  `PEAID` varchar(10) NOT NULL,
  `CreatedOn` varchar(60) NOT NULL,
  `RFQBusUnit` int(5) NOT NULL,
  `NoLinIems` varchar(10) NOT NULL,
  `Comment` text NOT NULL,
  `Ellapes` varchar(10) NOT NULL,
  `OnTQ` int(11) NOT NULL DEFAULT 0,
  `OnTQBy` int(3) NOT NULL,
  `OnTQOn` varchar(30) NOT NULL,
  `DateCreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dmrfq`
--

CREATE TABLE `dmrfq` (
  `RFQid` int(11) NOT NULL,
  `RFQNum` varchar(40) NOT NULL,
  `MirriorRFQ` varchar(40) NOT NULL,
  `RFQUpdate` text NOT NULL,
  `Status` varchar(40) DEFAULT NULL,
  `Customer` varchar(60) NOT NULL,
  `cusid` int(11) NOT NULL,
  `Attention` text NOT NULL,
  `Scope` varchar(15) NOT NULL,
  `DateStart` varchar(30) NOT NULL,
  `DateEnd` varchar(30) NOT NULL,
  `Source` varchar(10) NOT NULL,
  `Currency` varchar(30) NOT NULL,
  `Attachment` text NOT NULL,
  `CompanyRefNo` varchar(20) NOT NULL,
  `PENjobCode` varchar(30) NOT NULL,
  `BuyersNme` varchar(60) NOT NULL,
  `PEAssignee` varchar(60) NOT NULL,
  `PEAID` varchar(10) NOT NULL,
  `CreatedOn` varchar(60) NOT NULL,
  `RFQBusUnit` int(5) NOT NULL,
  `NoLinIems` varchar(10) NOT NULL,
  `Comment` text NOT NULL,
  `Ellapes` varchar(10) NOT NULL,
  `OnTQ` int(11) NOT NULL DEFAULT 0,
  `OnTQBy` int(3) NOT NULL,
  `OnTQOn` varchar(30) NOT NULL,
  `DateCreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `docclass`
--

CREATE TABLE `docclass` (
  `sdid` int(11) NOT NULL,
  `link` text NOT NULL,
  `description` text NOT NULL,
  `title` text NOT NULL,
  `addedby` int(2) NOT NULL,
  `addedon` varchar(60) NOT NULL,
  `module` varchar(100) NOT NULL,
  `docid` int(5) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `docs`
--

CREATE TABLE `docs` (
  `lactid` int(11) NOT NULL,
  `Type` varchar(24) NOT NULL,
  `CODE` text NOT NULL,
  `CreatedBy` varchar(4) NOT NULL,
  `CreatedOn` varchar(60) NOT NULL,
  `FileLink` text NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `subid` int(10) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `earnings_settings`
--

CREATE TABLE `earnings_settings` (
  `id` int(11) NOT NULL,
  `Description` varchar(200) NOT NULL,
  `CalMethod` int(3) NOT NULL,
  `AppliedToStaffGroup` int(11) NOT NULL,
  `EarningFrequ` int(3) NOT NULL,
  `GLMaster` int(6) NOT NULL,
  `Taxable` int(3) NOT NULL DEFAULT 1,
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emailtb`
--

CREATE TABLE `emailtb` (
  `emailid` int(11) NOT NULL,
  `actionID` text NOT NULL,
  `module` varchar(35) NOT NULL,
  `sender` int(3) NOT NULL,
  `recipent` varchar(100) NOT NULL,
  `CC` text NOT NULL,
  `BB` text NOT NULL,
  `Msg` text NOT NULL,
  `MsgType` varchar(20) NOT NULL,
  `MsgTitle` text NOT NULL,
  `attachments` text NOT NULL,
  `DateSent` timestamp NOT NULL DEFAULT current_timestamp(),
  `isActive` int(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `empcontacts`
--

CREATE TABLE `empcontacts` (
  `cid` int(11) NOT NULL,
  `user_id` int(5) NOT NULL,
  `ContactName` varchar(90) NOT NULL,
  `Relationship` varchar(60) NOT NULL,
  `Address` text NOT NULL,
  `PhoneNo` varchar(50) NOT NULL,
  `LGA` varchar(60) NOT NULL,
  `CreatedOn` timestamp NULL DEFAULT current_timestamp(),
  `CreatedBy` int(4) NOT NULL,
  `isActive` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `empdocuments`
--

CREATE TABLE `empdocuments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `attachments` text DEFAULT NULL,
  `description` text NOT NULL,
  `createdby` bigint(20) DEFAULT NULL,
  `modifiedby` bigint(20) DEFAULT NULL,
  `createddate` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifieddate` datetime NOT NULL,
  `isactive` tinyint(1) DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `empeducation`
--

CREATE TABLE `empeducation` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `eduInstitue` varchar(255) DEFAULT NULL,
  `eduYearFrom` varchar(10) DEFAULT NULL,
  `eduYearTo` varchar(10) NOT NULL,
  `eduTitle` text NOT NULL,
  `eduCert` text NOT NULL,
  `createdby` bigint(20) DEFAULT NULL,
  `modifiedby` bigint(20) DEFAULT NULL,
  `createddate` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifieddate` datetime NOT NULL,
  `isactive` tinyint(1) DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `empjobhistory`
--

CREATE TABLE `empjobhistory` (
  `cid` int(11) NOT NULL,
  `user_id` int(5) NOT NULL,
  `CompanyName` text NOT NULL,
  `YearFrom` varchar(60) NOT NULL,
  `YearTo` varchar(20) NOT NULL,
  `JobTitle` varchar(50) NOT NULL,
  `JobDescription` text NOT NULL,
  `CreatedOn` timestamp NULL DEFAULT current_timestamp(),
  `CreatedBy` int(4) NOT NULL,
  `isActive` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `empleave`
--

CREATE TABLE `empleave` (
  `id` int(11) NOT NULL,
  `uid` int(6) NOT NULL,
  `Dept` int(3) NOT NULL,
  `leaveType` varchar(50) NOT NULL,
  `leaveDaysApplied` text NOT NULL,
  `leaveDaysApproved` text NOT NULL,
  `Note` text NOT NULL,
  `CreatedOn` timestamp NULL DEFAULT current_timestamp(),
  `UHApprovedBy` int(4) NOT NULL,
  `isActive` tinyint(2) NOT NULL DEFAULT 1,
  `Status` int(3) NOT NULL DEFAULT 0,
  `UHApprovedOn` varchar(24) NOT NULL,
  `UHApprovalComment` text NOT NULL,
  `AccountsVA` varchar(24) NOT NULL,
  `CEOApproval` varchar(24) NOT NULL,
  `CEOComment` text NOT NULL,
  `CEOApprovedOn` varchar(24) NOT NULL,
  `StartDate` varchar(40) NOT NULL,
  `EndDate` varchar(40) NOT NULL,
  `NumberofDays` varchar(5) NOT NULL,
  `UserApp` int(4) NOT NULL,
  `UserAppDate` varchar(30) NOT NULL,
  `UserAppComment` text NOT NULL,
  `HODApp` int(11) NOT NULL,
  `HODAppDate` varchar(35) NOT NULL,
  `HODAppComment` text NOT NULL,
  `DivHApp` int(4) NOT NULL,
  `DivHAppDate` varchar(30) NOT NULL,
  `DivHAppComment` text NOT NULL,
  `GMApp` int(3) NOT NULL,
  `GMAppDate` varchar(30) NOT NULL,
  `GMAppComment` text NOT NULL,
  `GMCSApp` int(5) NOT NULL,
  `GMCSAppDate` varchar(30) NOT NULL,
  `GMCSAppComment` text NOT NULL,
  `HRApp` int(5) NOT NULL,
  `HRAppDate` varchar(30) NOT NULL,
  `HRAppComment` text NOT NULL,
  `MDApp` int(5) NOT NULL,
  `MDAppDate` varchar(30) NOT NULL,
  `MDAppComment` text NOT NULL,
  `AuditLog` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `empmedi`
--

CREATE TABLE `empmedi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `ailmentType` text DEFAULT NULL,
  `ailmentName` text DEFAULT NULL,
  `DiagnosedOn` text NOT NULL,
  `PresentCond` text NOT NULL,
  `mediDoc` text NOT NULL,
  `createdby` bigint(20) DEFAULT NULL,
  `modifiedby` bigint(20) DEFAULT NULL,
  `createddate` timestamp NOT NULL DEFAULT current_timestamp(),
  `modifieddate` datetime NOT NULL,
  `isactive` tinyint(1) DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `empskills`
--

CREATE TABLE `empskills` (
  `cid` int(11) NOT NULL,
  `user_id` int(5) NOT NULL,
  `Skill` text NOT NULL,
  `ObtainedFrm` varchar(60) NOT NULL,
  `ObtainedOn` text NOT NULL,
  `CreatedOn` timestamp NULL DEFAULT current_timestamp(),
  `CreatedBy` int(4) NOT NULL,
  `isActive` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `emptravel`
--

CREATE TABLE `emptravel` (
  `id` int(11) NOT NULL,
  `uid` int(6) NOT NULL,
  `travelType` varchar(50) NOT NULL,
  `travelDaysApplied` text NOT NULL,
  `travelDaysApproved` text NOT NULL,
  `Note` text NOT NULL,
  `Destination` text NOT NULL,
  `CreatedOn` timestamp NULL DEFAULT current_timestamp(),
  `UHApprovedBy` int(4) NOT NULL,
  `isActive` tinyint(2) NOT NULL DEFAULT 1,
  `Status` int(3) NOT NULL DEFAULT 0,
  `UHApprovedOn` varchar(24) NOT NULL,
  `UHApprovalComment` text NOT NULL,
  `AccountsVA` varchar(24) NOT NULL,
  `CEOApproval` varchar(24) NOT NULL,
  `CEOComment` text NOT NULL,
  `CEOApprovedOn` varchar(24) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enlinvoices`
--

CREATE TABLE `enlinvoices` (
  `cid` int(11) NOT NULL,
  `IVNo` text NOT NULL,
  `Comment` text NOT NULL,
  `conDiv` int(2) NOT NULL,
  `NGNRate` varchar(30) NOT NULL,
  `BnkID` int(4) NOT NULL,
  `CRDGL` varchar(10) NOT NULL,
  `IVDate` varchar(40) NOT NULL,
  `ENLATTN` int(4) NOT NULL,
  `CUSATTN` text NOT NULL,
  `CusSource` int(5) NOT NULL,
  `ServicENum` text NOT NULL,
  `RaisedBy` int(9) NOT NULL,
  `RaisedOn` varchar(30) NOT NULL,
  `FileLink` text NOT NULL,
  `Currency` varchar(10) NOT NULL,
  `VenCode` varchar(70) NOT NULL,
  `PONUM` text NOT NULL,
  `ContNum` int(5) NOT NULL,
  `Bank` int(5) NOT NULL,
  `LegalOfficer` int(2) NOT NULL,
  `LegalOfficerComment` text NOT NULL,
  `LegalOfficerOn` varchar(60) NOT NULL,
  `GMCSAppDate` varchar(30) NOT NULL,
  `GMCSAppComment` text NOT NULL,
  `GMCSApp` int(5) NOT NULL,
  `AllowDD` int(11) NOT NULL DEFAULT 0,
  `DDOfficer` int(2) NOT NULL,
  `DDOfficerComment` text NOT NULL,
  `DDOfficerOn` varchar(60) NOT NULL,
  `MDOffice` int(2) NOT NULL,
  `MDOfficeComment` text NOT NULL,
  `MDOfficeOn` varchar(60) NOT NULL,
  `AccountOfficer` int(2) NOT NULL,
  `AccountOfficerComment` text NOT NULL,
  `AccountOfficerOn` varchar(60) NOT NULL,
  `SETR` int(2) NOT NULL DEFAULT 0,
  `SERLog` text NOT NULL,
  `isActive` int(2) NOT NULL DEFAULT 1,
  `PostedOn` varchar(30) NOT NULL,
  `PostedBy` int(4) NOT NULL,
  `PostID` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='0';

-- --------------------------------------------------------

--
-- Table structure for table `enlivitems`
--

CREATE TABLE `enlivitems` (
  `poitid` int(11) NOT NULL,
  `PONo` varchar(60) NOT NULL,
  `PDFNUM` text NOT NULL,
  `PDFItemID` int(4) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `description` text NOT NULL,
  `units` varchar(40) NOT NULL,
  `qty` varchar(10) NOT NULL,
  `unitprice` varchar(10) NOT NULL,
  `CreatedOn` varchar(30) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `PostedOn` varchar(30) NOT NULL,
  `PostID` int(6) NOT NULL,
  `ItemGL` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `enlivmiscellaneous`
--

CREATE TABLE `enlivmiscellaneous` (
  `poitid` int(11) NOT NULL,
  `PONo` varchar(60) NOT NULL,
  `PDFNUM` text NOT NULL,
  `Impact` varchar(10) NOT NULL,
  `AmtType` varchar(30) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `description` text NOT NULL,
  `units` varchar(40) NOT NULL,
  `qty` varchar(10) NOT NULL,
  `price` varchar(10) NOT NULL,
  `CreatedOn` varchar(30) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `PostedOn` varchar(30) NOT NULL,
  `PostID` int(6) NOT NULL,
  `ItemGL` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `epcprojectdetails`
--

CREATE TABLE `epcprojectdetails` (
  `id` int(11) NOT NULL,
  `ProjSO` text NOT NULL,
  `ProjectName` varchar(150) NOT NULL,
  `ClientName` text NOT NULL,
  `Division` varchar(150) NOT NULL,
  `EndUser` text NOT NULL,
  `ProjectGoal` text NOT NULL,
  `ProjectOEM` text NOT NULL,
  `POReceivedDate` varchar(30) NOT NULL,
  `POAcknowledgedDate` varchar(30) NOT NULL,
  `ProjectStartDate` varchar(30) NOT NULL,
  `ProjectEndDate` varchar(30) NOT NULL,
  `ContractualDate` varchar(30) NOT NULL,
  `ExtensionDate` varchar(30) NOT NULL,
  `ItemDescription` text NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdateAudit` text NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `equipments`
--

CREATE TABLE `equipments` (
  `cid` int(11) NOT NULL,
  `EquipNo` text NOT NULL,
  `EquipNme` text NOT NULL,
  `EquipCode` varchar(20) NOT NULL,
  `EquipLoc` int(4) NOT NULL,
  `EquipCat` int(5) NOT NULL,
  `EquipType` int(5) NOT NULL,
  `EquipMan` int(4) NOT NULL,
  `EquipYrMake` varchar(20) NOT NULL,
  `Qty` int(10) NOT NULL,
  `UnitPrice` int(30) NOT NULL,
  `YearOfUse` varchar(30) NOT NULL,
  `Confirmed` text NOT NULL,
  `PerDepre` varchar(6) NOT NULL DEFAULT '5',
  `OficerInc` int(5) NOT NULL,
  `RaisedBy` int(2) NOT NULL,
  `RaisedOn` int(2) NOT NULL,
  `FileLink` text NOT NULL,
  `EquipFNo` varchar(20) NOT NULL,
  `Comment` text NOT NULL,
  `TotalSum` text NOT NULL,
  `LegalOfficer` int(2) NOT NULL,
  `LegalOfficerComment` text NOT NULL,
  `LegalOfficerOn` varchar(60) NOT NULL,
  `DDOfficer` int(2) NOT NULL,
  `DDOfficerComment` text NOT NULL,
  `DDOfficerOn` varchar(60) NOT NULL,
  `MDOffice` int(2) NOT NULL,
  `MDOfficeComment` text NOT NULL,
  `MDOfficeOn` varchar(60) NOT NULL,
  `AccountOfficer` int(2) NOT NULL,
  `AccountOfficerComment` text NOT NULL,
  `AccountOfficerOn` varchar(60) NOT NULL,
  `isActivate` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='0';

-- --------------------------------------------------------

--
-- Table structure for table `equip_category`
--

CREATE TABLE `equip_category` (
  `cid` int(3) NOT NULL,
  `station_name` varchar(60) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `ctype` tinyint(1) NOT NULL DEFAULT 0,
  `isActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `equip_manufacturers`
--

CREATE TABLE `equip_manufacturers` (
  `cid` int(3) NOT NULL,
  `station_name` varchar(60) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `ctype` tinyint(1) NOT NULL DEFAULT 0,
  `isActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `equip_stations`
--

CREATE TABLE `equip_stations` (
  `cid` int(3) NOT NULL,
  `station_name` varchar(60) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `ctype` tinyint(1) NOT NULL DEFAULT 0,
  `isActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `equip_subcategory`
--

CREATE TABLE `equip_subcategory` (
  `cid` int(3) NOT NULL,
  `station_name` varchar(60) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `ctype` tinyint(1) NOT NULL DEFAULT 0,
  `isActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `filereq`
--

CREATE TABLE `filereq` (
  `fid` int(11) NOT NULL,
  `reqtype` varchar(30) NOT NULL,
  `reqcode` varchar(30) NOT NULL,
  `tile` text NOT NULL,
  `fpath` text NOT NULL,
  `CreatedBy` int(3) NOT NULL,
  `CreatedOn` varchar(40) NOT NULL,
  `DeletedBy` int(4) NOT NULL,
  `DeletedOn` varchar(30) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gl_entries`
--

CREATE TABLE `gl_entries` (
  `eid` int(11) NOT NULL,
  `GLID` int(11) NOT NULL,
  `BANKID` int(8) NOT NULL,
  `Nature` varchar(60) NOT NULL,
  `mthNature` varchar(60) NOT NULL,
  `Amount` varchar(60) NOT NULL,
  `Transaction` varchar(60) NOT NULL,
  `Description` text NOT NULL,
  `SystemDescr` text NOT NULL,
  `InvoiceID` text NOT NULL,
  `CusONo` varchar(60) NOT NULL,
  `VenID` int(4) NOT NULL,
  `CusID` int(5) NOT NULL,
  `DivisionID` int(4) NOT NULL,
  `DepartmentID` int(4) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `isActive` int(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hir`
--

CREATE TABLE `hir` (
  `hirid` int(11) NOT NULL,
  `rptLocation` int(2) NOT NULL,
  `rptDate` varchar(30) NOT NULL,
  `Description` text NOT NULL,
  `ImAct` text NOT NULL,
  `FtAct` text NOT NULL,
  `PartyInv` text NOT NULL,
  `TargetDate` varchar(30) NOT NULL,
  `HType` varchar(20) NOT NULL,
  `RAMRating` text NOT NULL,
  `raisedby` int(11) NOT NULL,
  `raisedon` varchar(30) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `historylineitem`
--

CREATE TABLE `historylineitem` (
  `hlID` int(11) NOT NULL,
  `itno` int(13) NOT NULL,
  `martno` varchar(24) NOT NULL,
  `desp` text NOT NULL,
  `qty` int(13) NOT NULL,
  `uom` varchar(10) NOT NULL,
  `OEMPrice` varchar(50) NOT NULL,
  `FinalPRice` varchar(50) NOT NULL,
  `CusPO` text NOT NULL,
  `OEM` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hse_kpi`
--

CREATE TABLE `hse_kpi` (
  `id` int(10) NOT NULL,
  `kpi_name` text NOT NULL,
  `class_name` varchar(50) NOT NULL DEFAULT '',
  `isActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hse_kpi_data`
--

CREATE TABLE `hse_kpi_data` (
  `id` int(10) NOT NULL,
  `kpi_name` text NOT NULL,
  `kpi_date` varchar(30) NOT NULL,
  `kpi_data` varchar(30) NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `AuditLog` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ictreq`
--

CREATE TABLE `ictreq` (
  `reqid` int(11) NOT NULL,
  `isActive` int(3) NOT NULL DEFAULT 1,
  `staffName` varchar(120) NOT NULL,
  `staffID` int(11) NOT NULL,
  `RequestDate` varchar(26) NOT NULL,
  `RequestID` text NOT NULL,
  `Deparment` varchar(60) NOT NULL,
  `ItemDes` text NOT NULL,
  `Purpose` text NOT NULL,
  `Amount` varchar(60) NOT NULL,
  `Qty` int(20) NOT NULL,
  `Stage` varchar(60) NOT NULL,
  `LastActor` text NOT NULL,
  `ActorComment` text NOT NULL,
  `UserApp` int(3) NOT NULL DEFAULT 0,
  `UserAppDate` varchar(60) NOT NULL,
  `UserAppComment` text NOT NULL,
  `Approved` int(11) NOT NULL DEFAULT 0,
  `ApprovedBy` varchar(60) NOT NULL,
  `ApprovedDate` varchar(30) NOT NULL,
  `Status` varchar(30) DEFAULT 'Open'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `internalauditactivities`
--

CREATE TABLE `internalauditactivities` (
  `lactid` int(11) NOT NULL,
  `Type` varchar(24) NOT NULL,
  `CreatedBy` varchar(4) NOT NULL,
  `CreatedOn` varchar(60) NOT NULL,
  `FileLink` text NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `subid` int(10) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `internalauditsubjects`
--

CREATE TABLE `internalauditsubjects` (
  `sdid` int(11) NOT NULL,
  `link` text NOT NULL,
  `description` text NOT NULL,
  `title` text NOT NULL,
  `addedby` int(2) NOT NULL,
  `addedon` varchar(60) NOT NULL,
  `module` varchar(100) NOT NULL,
  `docid` int(5) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `itemcategory`
--

CREATE TABLE `itemcategory` (
  `id` int(11) NOT NULL,
  `CategoryName` text NOT NULL,
  `ShortCode` varchar(10) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ivitems`
--

CREATE TABLE `ivitems` (
  `poitid` int(11) NOT NULL,
  `PONo` varchar(60) NOT NULL,
  `PDFNUM` text NOT NULL,
  `PDFItemID` int(4) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `description` text NOT NULL,
  `units` varchar(40) NOT NULL,
  `qty` varchar(10) NOT NULL,
  `unitprice` varchar(10) NOT NULL,
  `CreatedOn` varchar(30) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `PostedOn` varchar(30) NOT NULL,
  `PostID` int(6) NOT NULL,
  `ItemGL` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ivmiscellaneous`
--

CREATE TABLE `ivmiscellaneous` (
  `poitid` int(11) NOT NULL,
  `PONo` varchar(60) NOT NULL,
  `PDFNUM` text NOT NULL,
  `Impact` varchar(10) NOT NULL,
  `AmtType` varchar(30) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `description` text NOT NULL,
  `units` varchar(40) NOT NULL,
  `qty` varchar(10) NOT NULL,
  `price` varchar(10) NOT NULL,
  `CreatedOn` varchar(30) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `PostedOn` varchar(30) NOT NULL,
  `PostID` int(6) NOT NULL,
  `ItemGL` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jettyequipments`
--

CREATE TABLE `jettyequipments` (
  `cid` int(11) NOT NULL,
  `EquipNo` text NOT NULL,
  `EquipNme` text NOT NULL,
  `EquipCode` varchar(20) NOT NULL,
  `EquipLoc` int(4) NOT NULL,
  `EquipMan` int(4) NOT NULL,
  `EquipYrMake` varchar(20) NOT NULL,
  `RaisedBy` int(2) NOT NULL,
  `RaisedOn` int(2) NOT NULL,
  `FileLink` text NOT NULL,
  `EquipFNo` varchar(20) NOT NULL,
  `Comment` text NOT NULL,
  `TotalSum` text NOT NULL,
  `LegalOfficer` int(2) NOT NULL,
  `LegalOfficerComment` text NOT NULL,
  `LegalOfficerOn` varchar(60) NOT NULL,
  `DDOfficer` int(2) NOT NULL,
  `DDOfficerComment` text NOT NULL,
  `DDOfficerOn` varchar(60) NOT NULL,
  `MDOffice` int(2) NOT NULL,
  `MDOfficeComment` text NOT NULL,
  `MDOfficeOn` varchar(60) NOT NULL,
  `AccountOfficer` int(2) NOT NULL,
  `AccountOfficerComment` text NOT NULL,
  `AccountOfficerOn` varchar(60) NOT NULL,
  `isActivate` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='0';

-- --------------------------------------------------------

--
-- Table structure for table `jettyreport`
--

CREATE TABLE `jettyreport` (
  `jid` int(11) NOT NULL,
  `ActivityType` varchar(60) NOT NULL,
  `ActivityStartDate` varchar(60) NOT NULL,
  `EquipUsed` text NOT NULL,
  `Activities` text NOT NULL,
  `Tonnage` text NOT NULL,
  `Vessel` text NOT NULL,
  `EDA` varchar(60) NOT NULL,
  `EDD` varchar(60) NOT NULL,
  `Comment` text NOT NULL,
  `CreatedOn` varchar(60) NOT NULL,
  `CreatedBy` int(4) NOT NULL,
  `isActive` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jha`
--

CREATE TABLE `jha` (
  `jhaid` int(11) NOT NULL,
  `ProjectTitle` text NOT NULL,
  `Client` text NOT NULL,
  `Location` text NOT NULL,
  `rptDate` varchar(60) NOT NULL,
  `TeamComposition` text NOT NULL,
  `raisedby` int(3) NOT NULL,
  `raisedon` int(4) NOT NULL,
  `isActive` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobposition`
--

CREATE TABLE `jobposition` (
  `id` int(11) NOT NULL,
  `JobTitleID` int(4) NOT NULL,
  `JobPosition` text NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `chid` int(11) NOT NULL,
  `cheuqeNME` text NOT NULL,
  `Bank` text NOT NULL,
  `Amt` text NOT NULL,
  `TDate` varchar(35) NOT NULL,
  `CreatedBy` int(2) NOT NULL,
  `CreatedOn` varchar(30) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobtitle`
--

CREATE TABLE `jobtitle` (
  `id` int(11) NOT NULL,
  `JobTitle` varchar(25) NOT NULL,
  `Description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `legalactivities`
--

CREATE TABLE `legalactivities` (
  `lactid` int(11) NOT NULL,
  `Type` varchar(20) NOT NULL,
  `CreatedBy` varchar(4) NOT NULL,
  `CreatedOn` varchar(60) NOT NULL,
  `FileLink` text NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `subid` int(10) NOT NULL,
  `title` text NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `legalmeetings`
--

CREATE TABLE `legalmeetings` (
  `sdid` int(11) NOT NULL,
  `venue` text NOT NULL,
  `mdate` varchar(40) NOT NULL,
  `link` text NOT NULL,
  `description` text NOT NULL,
  `title` text NOT NULL,
  `addedby` int(2) NOT NULL,
  `addedon` varchar(60) NOT NULL,
  `module` varchar(100) NOT NULL,
  `docid` int(5) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `legalsubjects`
--

CREATE TABLE `legalsubjects` (
  `sdid` int(11) NOT NULL,
  `link` text NOT NULL,
  `description` text NOT NULL,
  `title` text NOT NULL,
  `addedby` int(2) NOT NULL,
  `addedon` varchar(60) NOT NULL,
  `module` varchar(100) NOT NULL,
  `docid` int(5) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lineitems`
--

CREATE TABLE `lineitems` (
  `LitID` int(11) NOT NULL,
  `RFQCode` varchar(40) NOT NULL,
  `Status` varchar(13) NOT NULL DEFAULT 'OPEN',
  `MatSer` varchar(60) NOT NULL,
  `Description` text NOT NULL,
  `Qty` varchar(20) NOT NULL,
  `UOM` varchar(10) NOT NULL,
  `SupDetail` text NOT NULL,
  `Price` varchar(60) NOT NULL,
  `Currency` varchar(10) NOT NULL,
  `ConvertRatePerN` varchar(40) NOT NULL,
  `UnitCost` varchar(60) NOT NULL,
  `ExtendedCost` varchar(60) NOT NULL,
  `Discount` varchar(40) NOT NULL,
  `DiscountAmt` varchar(40) NOT NULL,
  `UnitWeight` varchar(40) NOT NULL,
  `ExWeight` varchar(40) NOT NULL,
  `FOBExWorks` varchar(60) NOT NULL,
  `PackingPercent` varchar(5) NOT NULL,
  `ExportPackaging` varchar(60) NOT NULL,
  `InsurePercent` varchar(6) NOT NULL,
  `Insurance` varchar(60) NOT NULL,
  `FreightPercent` varchar(6) NOT NULL,
  `Freight` varchar(60) NOT NULL,
  `FreightDirect` varchar(10) NOT NULL DEFAULT 'checked',
  `ForeignCost` varchar(60) NOT NULL,
  `HScode` varchar(30) NOT NULL,
  `HsTarrif` varchar(60) NOT NULL,
  `CustomDuty` varchar(60) NOT NULL,
  `CustomSubCharge` varchar(60) NOT NULL,
  `ETLSCharge` varchar(60) NOT NULL,
  `CustDuty` varchar(20) NOT NULL,
  `LocalHandling` varchar(60) NOT NULL,
  `pLocalHandling` int(4) NOT NULL,
  `MarkUp` varchar(60) NOT NULL,
  `MarkUpDirect` varchar(10) NOT NULL DEFAULT 'checked',
  `LocalCost` varchar(60) NOT NULL,
  `Currencyv` varchar(20) NOT NULL,
  `EntryDate` varchar(30) NOT NULL,
  `TimeDone` varchar(20) NOT NULL,
  `PreShipmentInspect` varchar(60) NOT NULL,
  `CustomVat` varchar(60) NOT NULL,
  `WHT` varchar(60) NOT NULL,
  `NCD` varchar(60) NOT NULL,
  `UnitDDPrice` varchar(60) NOT NULL,
  `ExDDPrice` varchar(60) NOT NULL,
  `VAT` varchar(60) NOT NULL,
  `BILL` varchar(60) NOT NULL,
  `DELIVERY` varchar(60) NOT NULL,
  `WorkLocation` varchar(60) NOT NULL,
  `DeliveryToWrkLocation` varchar(60) NOT NULL,
  `ExMarkUp` varchar(60) NOT NULL,
  `Customer` text NOT NULL,
  `ProjectControl` int(11) NOT NULL DEFAULT 0,
  `markupperc` varchar(24) NOT NULL,
  `EXPPrice` varchar(500) NOT NULL,
  `CIFPPrice` varchar(500) NOT NULL,
  `DPPPrice` varchar(500) NOT NULL,
  `incoterm` varchar(20) NOT NULL,
  `doincoterm` varchar(20) NOT NULL,
  `applydoincoterm` int(2) NOT NULL,
  `Division` text NOT NULL,
  `OnTQ` int(11) NOT NULL DEFAULT 0,
  `OnTQBy` int(11) NOT NULL,
  `OnTQOn` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `logistics`
--

CREATE TABLE `logistics` (
  `logID` int(11) NOT NULL,
  `GoodsRv` int(2) NOT NULL DEFAULT 0,
  `InvoiceN` varchar(30) NOT NULL,
  `LocalHandlingQ` varchar(50) NOT NULL,
  `LocalHandlingP` varchar(50) NOT NULL,
  `FreightQ` varchar(50) NOT NULL,
  `FreightP` varchar(50) NOT NULL,
  `ShipmentN` varchar(40) NOT NULL,
  `CreatedGoodsRvByOn` text NOT NULL,
  `GoodsRvBy` int(11) NOT NULL,
  `GoodsDisp` int(2) NOT NULL DEFAULT 0,
  `DeliveryRN` varchar(40) NOT NULL,
  `GRSlipN` varchar(40) NOT NULL,
  `GRSlipDate` varchar(40) NOT NULL,
  `GoodsDispBy` int(11) NOT NULL,
  `CreatedGoodsDispByOn` text NOT NULL,
  `PartialDeli` int(2) NOT NULL DEFAULT 0,
  `CreatedPartialDeliByOn` text NOT NULL,
  `FullDeli` int(2) NOT NULL DEFAULT 0,
  `CreatedFullDeliByOn` text NOT NULL,
  `FullDeliveryOn` varchar(30) NOT NULL,
  `POID` text NOT NULL,
  `OEM` text NOT NULL,
  `OEMUpdate` text NOT NULL,
  `AttachmentUpdate` text NOT NULL,
  `DeliveryUpdate` text NOT NULL,
  `MartServNo` varchar(50) NOT NULL,
  `lineItID` int(10) NOT NULL,
  `Description` text NOT NULL,
  `Qty` int(20) NOT NULL,
  `UOM` varchar(15) NOT NULL,
  `RVFm` int(2) NOT NULL DEFAULT 0,
  `RVFmBy` int(11) NOT NULL,
  `CreatedRVFmByOn` text NOT NULL,
  `RWBill` int(2) NOT NULL DEFAULT 0,
  `RWBillBy` int(11) NOT NULL,
  `CreatedRWBillByOn` text NOT NULL,
  `OPWh` int(2) NOT NULL DEFAULT 0,
  `OPWhBy` int(11) NOT NULL,
  `CreatedOPWhByOn` text NOT NULL,
  `POAmt` varchar(30) NOT NULL,
  `UnitRate` varchar(50) NOT NULL,
  `PODiscount` varchar(30) NOT NULL,
  `POComment` text NOT NULL,
  `DueDate` varchar(60) NOT NULL,
  `DDPDATE` varchar(25) NOT NULL,
  `sOpen` int(2) NOT NULL DEFAULT 0,
  `SetForIn` int(11) NOT NULL,
  `SetForInBy` int(11) NOT NULL,
  `PreAcc` int(11) NOT NULL,
  `PostAcc` int(11) NOT NULL,
  `RecPay` int(11) NOT NULL,
  `isA` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `maintain_activities`
--

CREATE TABLE `maintain_activities` (
  `maid` int(11) NOT NULL,
  `equipid` int(3) NOT NULL,
  `action` text NOT NULL,
  `remark` text NOT NULL,
  `partereplaced` text NOT NULL,
  `raisedby` varchar(35) NOT NULL,
  `raisedon` varchar(35) NOT NULL,
  `duedate` varchar(20) NOT NULL,
  `done` int(2) NOT NULL DEFAULT 0,
  `isActive` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mljobs`
--

CREATE TABLE `mljobs` (
  `JOBid` int(11) NOT NULL,
  `JOBNum` text NOT NULL,
  `JOBType` varchar(30) NOT NULL,
  `MirriorRFQ` varchar(40) NOT NULL,
  `RFQUpdate` text NOT NULL,
  `Status` varchar(40) DEFAULT NULL,
  `Customer` varchar(60) NOT NULL,
  `cusid` int(11) NOT NULL,
  `Attention` text NOT NULL,
  `Scope` varchar(15) NOT NULL,
  `DateStart` varchar(30) NOT NULL,
  `DateEnd` varchar(30) NOT NULL,
  `Source` varchar(30) NOT NULL,
  `Currency` varchar(30) NOT NULL,
  `Attachment` text NOT NULL,
  `CompanyRefNo` varchar(20) NOT NULL,
  `PENjobCode` varchar(30) NOT NULL,
  `BuyersNme` varchar(60) NOT NULL,
  `PEAssignee` varchar(60) NOT NULL,
  `PEAID` varchar(10) NOT NULL,
  `CreatedOn` varchar(60) NOT NULL,
  `RFQBusUnit` int(5) NOT NULL,
  `NoLinIems` varchar(10) NOT NULL,
  `Comment` text NOT NULL,
  `Ellapes` varchar(10) NOT NULL,
  `OnTQ` int(11) NOT NULL DEFAULT 0,
  `OnTQBy` int(3) NOT NULL,
  `OnTQOn` varchar(30) NOT NULL,
  `DateCreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `msg`
--

CREATE TABLE `msg` (
  `msgid` int(11) NOT NULL,
  `msgtype` varchar(12) NOT NULL,
  `msgTitle` text NOT NULL,
  `msg` text NOT NULL,
  `hlink` text NOT NULL,
  `sender` int(11) NOT NULL,
  `recipents` varchar(24) NOT NULL,
  `originrecipients` varchar(120) NOT NULL,
  `activityLog` text NOT NULL,
  `received` int(11) NOT NULL DEFAULT 0,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `isActive` int(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `noncon`
--

CREATE TABLE `noncon` (
  `nid` int(11) NOT NULL,
  `Category` varchar(80) NOT NULL,
  `RptDate` varchar(30) NOT NULL,
  `Client` text NOT NULL,
  `AuditArea` text NOT NULL,
  `Description` text NOT NULL,
  `RootCause` text NOT NULL,
  `CorrectiveAction` text NOT NULL,
  `AgreedDate` varchar(30) NOT NULL,
  `PreventiveAction` text NOT NULL,
  `Verification` text NOT NULL,
  `PersonResponsible` text NOT NULL,
  `Auditor` varchar(30) NOT NULL,
  `CreatedBy` int(2) NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 1,
  `isActive` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `noteID` int(11) NOT NULL,
  `StaffID` varchar(30) NOT NULL,
  `Message` text NOT NULL,
  `SendersID` int(11) NOT NULL,
  `msgType` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `npo`
--

CREATE TABLE `npo` (
  `RFQid` int(11) NOT NULL,
  `RFQNum` varchar(40) NOT NULL,
  `Status` varchar(40) DEFAULT NULL,
  `Customer` varchar(60) NOT NULL,
  `Scope` varchar(15) NOT NULL,
  `DateRange` varchar(60) NOT NULL,
  `Source` varchar(10) NOT NULL,
  `Attachment` longblob NOT NULL,
  `CompanyRefNo` varchar(20) NOT NULL,
  `PENjobCode` varchar(30) NOT NULL,
  `BuyersNme` varchar(60) NOT NULL,
  `PEAssignee` varchar(60) NOT NULL,
  `PEAID` varchar(10) NOT NULL,
  `NoLinIems` varchar(10) NOT NULL,
  `Comment` text NOT NULL,
  `Ellapes` varchar(10) NOT NULL,
  `DateCreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `opt_cal_method`
--

CREATE TABLE `opt_cal_method` (
  `calid` int(11) NOT NULL,
  `Description` text NOT NULL,
  `Percentage` int(11) NOT NULL,
  `ELEMENT` int(10) NOT NULL,
  `Nature` varchar(12) NOT NULL DEFAULT 'GROSS',
  `isActive` int(11) NOT NULL DEFAULT 1,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `CreatedBy` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `opt_earning_freq`
--

CREATE TABLE `opt_earning_freq` (
  `enfreqid` int(11) NOT NULL,
  `EarningFrequ` text NOT NULL,
  `WorkHrs` int(11) NOT NULL,
  `OneOff` varchar(5) NOT NULL DEFAULT 'YES',
  `Date` timestamp NULL DEFAULT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `opt_employee_group`
--

CREATE TABLE `opt_employee_group` (
  `empgid` int(11) NOT NULL,
  `Description` text NOT NULL,
  `Employees` text NOT NULL,
  `isActive` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `otherreceiver`
--

CREATE TABLE `otherreceiver` (
  `uid` int(9) NOT NULL,
  `FullName` text NOT NULL,
  `CreatedBy` int(4) NOT NULL,
  `CreatedOn` varchar(30) NOT NULL,
  `isActive` int(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payrollelement`
--

CREATE TABLE `payrollelement` (
  `payid` int(11) NOT NULL,
  `payname` text NOT NULL,
  `caltype` varchar(30) NOT NULL,
  `valtype` varchar(30) NOT NULL,
  `payval` varchar(40) NOT NULL,
  `isActive` int(3) NOT NULL DEFAULT 1,
  `CreatedBy` int(4) NOT NULL,
  `CreatedOn` varchar(34) NOT NULL,
  `ULog` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payrollsettings`
--

CREATE TABLE `payrollsettings` (
  `pyid` int(11) NOT NULL,
  `CompanyRegNo` varchar(60) NOT NULL,
  `NHISNo` varchar(60) NOT NULL,
  `TAXTINNo` varchar(60) NOT NULL,
  `ITFLevyNo` varchar(60) NOT NULL,
  `NHFNo` varchar(60) NOT NULL,
  `NSITFNo` varchar(60) NOT NULL,
  `ProRataCal` varchar(16) NOT NULL DEFAULT 'Calendar Days',
  `isActive` int(2) NOT NULL,
  `ULog` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pecheques`
--

CREATE TABLE `pecheques` (
  `pechq` int(11) NOT NULL,
  `so` text NOT NULL,
  `CusONo` text NOT NULL,
  `venid` int(10) NOT NULL,
  `ChequeNo` varchar(60) NOT NULL,
  `OrderNo` varchar(60) NOT NULL,
  `VendorCode` varchar(60) NOT NULL,
  `InvDate` varchar(24) NOT NULL,
  `TermDay` int(5) NOT NULL,
  `Currency` varchar(12) NOT NULL,
  `NGNCRate` varchar(50) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `AuditLog` text NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 1,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `po`
--

CREATE TABLE `po` (
  `poID` int(11) NOT NULL,
  `PONum` varchar(30) NOT NULL,
  `Status` varchar(30) NOT NULL,
  `Supplier` varchar(80) NOT NULL,
  `SupplierID` int(11) NOT NULL,
  `StaffID` varchar(60) NOT NULL,
  `ItemsN` varchar(10) NOT NULL,
  `ItemsDetails` text NOT NULL,
  `SubTotal` varchar(24) NOT NULL,
  `Discount` int(30) NOT NULL,
  `pTax` int(10) NOT NULL,
  `Tax` varchar(24) NOT NULL,
  `Total` varchar(50) NOT NULL,
  `POdate` varchar(20) NOT NULL,
  `POLocation` text NOT NULL,
  `POAssignStaff` varchar(30) NOT NULL,
  `ItemList` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `poinfo`
--

CREATE TABLE `poinfo` (
  `POinfoID` int(11) NOT NULL,
  `PONum` varchar(60) NOT NULL,
  `Terms` text NOT NULL,
  `SpecialNote` text NOT NULL,
  `Supplier` text NOT NULL,
  `Currency` varchar(20) NOT NULL,
  `CurrencySymb` varchar(10) NOT NULL,
  `SupplierRefNum` text NOT NULL,
  `OtherRefNum` text NOT NULL,
  `DespatchThrough` text NOT NULL,
  `Destination` text NOT NULL,
  `ConNme` varchar(60) NOT NULL,
  `ConEmail` varchar(60) NOT NULL,
  `ConPhone` varchar(60) NOT NULL,
  `PODate` varchar(50) NOT NULL,
  `SubTotal` text NOT NULL,
  `Total` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `poinfocomm`
--

CREATE TABLE `poinfocomm` (
  `POinfocommID` int(11) NOT NULL,
  `PONum` text NOT NULL,
  `sn` int(11) NOT NULL,
  `Amount` text NOT NULL,
  `Title` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `poinfolineitem`
--

CREATE TABLE `poinfolineitem` (
  `POinfoID` int(11) NOT NULL,
  `PONum` text NOT NULL,
  `sn` int(30) NOT NULL,
  `Description` text NOT NULL,
  `DueOn` varchar(50) NOT NULL,
  `Quantity` varchar(30) NOT NULL,
  `Rate` varchar(30) NOT NULL,
  `Per` varchar(30) NOT NULL,
  `Discount` varchar(30) NOT NULL,
  `Amount` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `poitems`
--

CREATE TABLE `poitems` (
  `poitid` int(11) NOT NULL,
  `PONo` varchar(60) NOT NULL,
  `PDFNUM` text NOT NULL,
  `PDFItemID` int(4) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `description` text NOT NULL,
  `units` varchar(40) NOT NULL,
  `qty` varchar(10) NOT NULL,
  `unitprice` varchar(10) NOT NULL,
  `CreatedOn` varchar(30) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `polineitems`
--

CREATE TABLE `polineitems` (
  `LitID` int(11) NOT NULL,
  `RFQCode` varchar(40) NOT NULL,
  `Status` varchar(13) NOT NULL DEFAULT 'OPEN',
  `MatSer` varchar(60) NOT NULL,
  `Description` text NOT NULL,
  `Qty` varchar(20) NOT NULL,
  `UOM` varchar(10) NOT NULL,
  `SupDetail` text NOT NULL,
  `Price` varchar(60) NOT NULL,
  `Currency` varchar(10) NOT NULL,
  `ConvertRatePerN` varchar(40) NOT NULL,
  `UnitCost` varchar(60) NOT NULL,
  `ExtendedCost` varchar(60) NOT NULL,
  `Discount` varchar(40) NOT NULL,
  `DiscountAmt` varchar(40) NOT NULL,
  `UnitWeight` varchar(40) NOT NULL,
  `ExWeight` varchar(40) NOT NULL,
  `FOBExWorks` varchar(60) NOT NULL,
  `PackingPercent` varchar(5) NOT NULL,
  `ExportPackaging` varchar(60) NOT NULL,
  `InsurePercent` varchar(6) NOT NULL,
  `Insurance` varchar(60) NOT NULL,
  `FreightPercent` varchar(6) NOT NULL,
  `Freight` varchar(60) NOT NULL,
  `FreightDirect` varchar(15) NOT NULL DEFAULT 'checked',
  `ForeignCost` varchar(60) NOT NULL,
  `HScode` varchar(30) NOT NULL,
  `HsTarrif` varchar(60) NOT NULL,
  `CustomDuty` varchar(60) NOT NULL,
  `CustomSubCharge` varchar(60) NOT NULL,
  `ETLSCharge` varchar(60) NOT NULL,
  `LocalHandling` varchar(60) NOT NULL,
  `pLocalHandling` int(4) NOT NULL,
  `MarkUp` varchar(60) NOT NULL,
  `MarkUpDirect` varchar(23) NOT NULL DEFAULT 'checked',
  `LocalCost` varchar(60) NOT NULL,
  `Currencyv` varchar(20) NOT NULL,
  `EntryDate` varchar(30) NOT NULL,
  `TimeDone` varchar(20) NOT NULL,
  `PreShipmentInspect` varchar(60) NOT NULL,
  `CustomVat` varchar(60) NOT NULL,
  `WHT` varchar(60) NOT NULL,
  `NCD` varchar(60) NOT NULL,
  `UnitDDPrice` varchar(60) NOT NULL,
  `ExDDPrice` varchar(60) NOT NULL,
  `VAT` varchar(60) NOT NULL,
  `BILL` varchar(60) NOT NULL,
  `DELIVERY` varchar(60) NOT NULL,
  `WorkLocation` varchar(60) NOT NULL,
  `DeliveryToWrkLocation` varchar(60) NOT NULL,
  `ExMarkUp` varchar(60) NOT NULL,
  `Customer` text NOT NULL,
  `ProjectControl` int(11) NOT NULL DEFAULT 0,
  `markupperc` varchar(20) NOT NULL,
  `CreateSO` int(2) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `CreatedBy` int(10) NOT NULL,
  `Tech` int(2) NOT NULL,
  `TechCreatedBy` int(5) NOT NULL,
  `MOS` int(2) NOT NULL,
  `MOSCreatedBy` int(5) NOT NULL,
  `Comm` int(2) NOT NULL,
  `CommCreatedBy` int(11) NOT NULL,
  `legal` int(2) NOT NULL DEFAULT 0,
  `legalBy` int(3) NOT NULL,
  `legalOn` varchar(16) NOT NULL,
  `EXPPrice` varchar(500) NOT NULL,
  `CIFPPrice` varchar(500) NOT NULL,
  `DPPPrice` varchar(500) NOT NULL,
  `incoterm` varchar(20) NOT NULL,
  `doincoterm` varchar(30) NOT NULL,
  `applydoincoterm` int(2) NOT NULL,
  `Division` text NOT NULL,
  `OnTQ` int(11) NOT NULL DEFAULT 0,
  `OnTQBy` int(11) NOT NULL,
  `OnTQOn` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pomiscellaneous`
--

CREATE TABLE `pomiscellaneous` (
  `poitid` int(11) NOT NULL,
  `PONo` varchar(60) NOT NULL,
  `PDFNUM` text NOT NULL,
  `Impact` varchar(10) NOT NULL,
  `AmtType` varchar(30) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `description` text NOT NULL,
  `units` varchar(40) NOT NULL,
  `qty` varchar(10) NOT NULL,
  `price` varchar(10) NOT NULL,
  `CreatedOn` varchar(30) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `poreq`
--

CREATE TABLE `poreq` (
  `reqid` int(11) NOT NULL,
  `isActive` int(3) NOT NULL DEFAULT 1,
  `DeletedBy` int(5) NOT NULL,
  `DeletedOn` varchar(30) NOT NULL,
  `staffName` varchar(120) NOT NULL,
  `staffID` int(11) NOT NULL,
  `RequestDate` varchar(26) NOT NULL,
  `RequestID` text NOT NULL,
  `Deparment` varchar(60) NOT NULL,
  `ItemDes` text NOT NULL,
  `Purpose` text NOT NULL,
  `Amount` varchar(60) NOT NULL,
  `Size` varchar(30) NOT NULL,
  `UOM` varchar(30) NOT NULL,
  `Type` varchar(50) NOT NULL,
  `Qty` int(20) NOT NULL,
  `Stage` varchar(60) NOT NULL,
  `LastActor` text NOT NULL,
  `UserApp` int(3) NOT NULL DEFAULT 0,
  `UserAppDate` varchar(60) NOT NULL,
  `UserAppComment` text NOT NULL,
  `SupervisorApp` int(2) NOT NULL,
  `SupervisorAppDate` varchar(40) NOT NULL,
  `SupervisorComment` text NOT NULL,
  `DeptHeadApp` int(2) NOT NULL DEFAULT 0,
  `DeptHeadAppDate` varchar(60) NOT NULL,
  `DeptHeadAppComment` text NOT NULL,
  `DivHeadApp` int(2) NOT NULL DEFAULT 0,
  `DivHeadAppDate` varchar(60) NOT NULL,
  `DivHeadAppComment` text NOT NULL,
  `CPApp` int(3) NOT NULL,
  `CPAppDate` varchar(60) NOT NULL,
  `CPAppComment` text NOT NULL,
  `CSApp` int(5) NOT NULL,
  `CSAppDate` varchar(60) NOT NULL,
  `CSAppComment` text NOT NULL,
  `MgrApp` int(2) NOT NULL DEFAULT 0,
  `MgrAppDate` varchar(60) NOT NULL,
  `MgrAppComment` text NOT NULL,
  `DDApp` int(2) NOT NULL,
  `DDAppDate` varchar(60) NOT NULL,
  `DDAppComment` text NOT NULL,
  `COOApp` int(11) NOT NULL,
  `COOAppDate` varchar(32) NOT NULL,
  `COOComment` text NOT NULL,
  `MDApp` int(3) NOT NULL,
  `MDAppDate` varchar(40) NOT NULL,
  `MDComment` text NOT NULL,
  `Approved` int(11) NOT NULL DEFAULT 0,
  `ApprovedBy` varchar(60) NOT NULL,
  `ApprovedDate` varchar(30) NOT NULL,
  `attachment` text NOT NULL,
  `fDeletedBy` int(5) NOT NULL,
  `fDeletedOn` varchar(30) NOT NULL,
  `Status` text DEFAULT NULL,
  `DDOfficerApp` varchar(37) NOT NULL,
  `DDOfficerAppDate` varchar(30) NOT NULL,
  `DDOfficerAppComment` text NOT NULL,
  `CPActor` int(5) NOT NULL,
  `CPRemark` text NOT NULL,
  `CPActDate` varchar(30) NOT NULL,
  `CPActType` text NOT NULL,
  `CASHNUM` text NOT NULL,
  `PONUM` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `postings`
--

CREATE TABLE `postings` (
  `tncid` int(11) NOT NULL,
  `REQCODE` varchar(30) NOT NULL,
  `mItem` int(2) NOT NULL DEFAULT 0,
  `mJob` int(5) NOT NULL,
  `CHRID` varchar(14) NOT NULL,
  `ItemQty` int(30) NOT NULL,
  `EquipC` int(4) NOT NULL,
  `BankAccount` int(5) NOT NULL,
  `ChqNo` varchar(30) NOT NULL,
  `ReceivedBy` varchar(10) NOT NULL,
  `GLImpacted` int(5) NOT NULL,
  `GLDescription` text NOT NULL,
  `GLDescriptionPB` text NOT NULL,
  `TransactionAmount` varchar(30) NOT NULL,
  `PostedAmount` varchar(30) NOT NULL,
  `TransacType` varchar(10) NOT NULL,
  `CounterTrans` varchar(60) NOT NULL,
  `TransactionDate` varchar(30) NOT NULL,
  `Remark` text NOT NULL,
  `CostRevenueCenter` int(5) NOT NULL,
  `VendorID` int(5) NOT NULL,
  `VINVOICE` text NOT NULL,
  `CusID` int(12) NOT NULL,
  `ENLINVOICE` varchar(12) NOT NULL,
  `StaffID` int(5) NOT NULL,
  `Currency` varchar(15) NOT NULL,
  `NGNTCURR` varchar(30) NOT NULL,
  `CRCenter` int(5) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `PostedBy` int(5) NOT NULL,
  `PostedOn` varchar(30) NOT NULL,
  `RptType` varchar(140) NOT NULL,
  `RptType1` text NOT NULL,
  `DelLog` text NOT NULL,
  `DelGroup` varchar(30) NOT NULL,
  `UpdateLog` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `postingsnew`
--

CREATE TABLE `postingsnew` (
  `tncid` int(11) NOT NULL,
  `REQCODE` varchar(30) NOT NULL,
  `mItem` int(2) NOT NULL DEFAULT 0,
  `mJob` int(5) NOT NULL,
  `CHRID` varchar(14) NOT NULL,
  `ItemQty` int(30) NOT NULL,
  `EquipC` int(4) NOT NULL,
  `BankAccount` int(5) NOT NULL,
  `ChqNo` varchar(30) NOT NULL,
  `ReceivedBy` varchar(10) NOT NULL,
  `GLImpacted` int(5) NOT NULL,
  `GLDescription` text NOT NULL,
  `GLDescriptionPB` text NOT NULL,
  `TransactionAmount` varchar(30) NOT NULL,
  `PostedAmount` varchar(30) NOT NULL,
  `TransacType` varchar(10) NOT NULL,
  `CounterTrans` varchar(60) NOT NULL,
  `TransactionDate` varchar(30) NOT NULL,
  `Remark` text NOT NULL,
  `CostRevenueCenter` int(5) NOT NULL,
  `VendorID` int(5) NOT NULL,
  `VINVOICE` text NOT NULL,
  `CusID` int(12) NOT NULL,
  `ENLINVOICE` varchar(12) NOT NULL,
  `StaffID` int(5) NOT NULL,
  `Currency` varchar(15) NOT NULL,
  `NGNTCURR` varchar(30) NOT NULL,
  `CRCenter` int(5) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `PostedBy` int(5) NOT NULL,
  `PostedOn` varchar(30) NOT NULL,
  `RptType` varchar(140) NOT NULL,
  `RptType1` text NOT NULL,
  `DelLog` text NOT NULL,
  `UpdateLog` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `posting_update`
--

CREATE TABLE `posting_update` (
  `puid` int(11) NOT NULL,
  `doneby` int(6) NOT NULL,
  `doneon` varchar(37) NOT NULL,
  `postid` int(5) NOT NULL,
  `OldGL` varchar(11) NOT NULL,
  `NewGL` varchar(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ppe_kit`
--

CREATE TABLE `ppe_kit` (
  `id` int(10) NOT NULL,
  `ppe_name` text NOT NULL,
  `isActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `pid` int(11) NOT NULL,
  `productname` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projdeliverables`
--

CREATE TABLE `projdeliverables` (
  `LitID` int(11) NOT NULL,
  `PROJCode` varchar(40) NOT NULL,
  `Status` varchar(13) NOT NULL DEFAULT 'OPEN',
  `MatSer` varchar(60) NOT NULL,
  `Description` text NOT NULL,
  `Qty` varchar(20) NOT NULL,
  `UOM` varchar(10) NOT NULL,
  `SupDetail` text NOT NULL,
  `Price` varchar(60) NOT NULL,
  `Currency` varchar(10) NOT NULL,
  `ConvertRatePerN` varchar(40) NOT NULL,
  `UnitCost` varchar(60) NOT NULL,
  `ExtendedCost` varchar(60) NOT NULL,
  `Discount` varchar(40) NOT NULL,
  `DiscountAmt` varchar(40) NOT NULL,
  `UnitWeight` varchar(40) NOT NULL,
  `ExWeight` varchar(40) NOT NULL,
  `FOBExWorks` varchar(60) NOT NULL,
  `PackingPercent` varchar(5) NOT NULL,
  `ExportPackaging` varchar(60) NOT NULL,
  `InsurePercent` varchar(6) NOT NULL,
  `Insurance` varchar(60) NOT NULL,
  `FreightPercent` varchar(6) NOT NULL,
  `Freight` varchar(60) NOT NULL,
  `FreightDirect` varchar(10) NOT NULL DEFAULT 'checked',
  `ForeignCost` varchar(60) NOT NULL,
  `HScode` varchar(30) NOT NULL,
  `HsTarrif` varchar(60) NOT NULL,
  `CustomDuty` varchar(60) NOT NULL,
  `CustomSubCharge` varchar(60) NOT NULL,
  `ETLSCharge` varchar(60) NOT NULL,
  `CustDuty` varchar(20) NOT NULL,
  `LocalHandling` varchar(60) NOT NULL,
  `pLocalHandling` int(4) NOT NULL,
  `MarkUp` varchar(60) NOT NULL,
  `MarkUpDirect` varchar(10) NOT NULL DEFAULT 'checked',
  `LocalCost` varchar(60) NOT NULL,
  `Currencyv` varchar(20) NOT NULL,
  `EntryDate` varchar(30) NOT NULL,
  `TimeDone` varchar(20) NOT NULL,
  `PreShipmentInspect` varchar(60) NOT NULL,
  `CustomVat` varchar(60) NOT NULL,
  `WHT` varchar(60) NOT NULL,
  `NCD` varchar(60) NOT NULL,
  `UnitDDPrice` varchar(60) NOT NULL,
  `ExDDPrice` varchar(60) NOT NULL,
  `VAT` varchar(60) NOT NULL,
  `BILL` varchar(60) NOT NULL,
  `DELIVERY` varchar(60) NOT NULL,
  `WorkLocation` varchar(60) NOT NULL,
  `DeliveryToWrkLocation` varchar(60) NOT NULL,
  `ExMarkUp` varchar(60) NOT NULL,
  `Customer` text NOT NULL,
  `ProjectControl` int(11) NOT NULL DEFAULT 0,
  `markupperc` varchar(24) NOT NULL,
  `EXPPrice` varchar(500) NOT NULL,
  `CIFPPrice` varchar(500) NOT NULL,
  `DPPPrice` varchar(500) NOT NULL,
  `incoterm` varchar(20) NOT NULL,
  `doincoterm` varchar(20) NOT NULL,
  `applydoincoterm` int(2) NOT NULL,
  `Division` text NOT NULL,
  `OnTQ` int(11) NOT NULL DEFAULT 0,
  `OnTQBy` int(11) NOT NULL,
  `OnTQOn` varchar(30) NOT NULL,
  `addedby` int(3) NOT NULL,
  `addedon` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `PROJid` int(11) NOT NULL,
  `PROJNum` text NOT NULL,
  `MirriorPO` text NOT NULL,
  `CorContract` text NOT NULL,
  `CorRFQ` text NOT NULL,
  `RFQUpdate` text NOT NULL,
  `Status` varchar(40) DEFAULT NULL,
  `Customer` varchar(60) NOT NULL,
  `cusid` int(11) NOT NULL,
  `Attention` text NOT NULL,
  `Scope` varchar(15) NOT NULL,
  `DateStart` varchar(30) NOT NULL,
  `DateEnd` varchar(30) NOT NULL,
  `Source` varchar(10) NOT NULL,
  `Currency` varchar(30) NOT NULL,
  `Attachment` text NOT NULL,
  `CompanyRefNo` varchar(20) NOT NULL,
  `PENjobCode` varchar(30) NOT NULL,
  `BuyersNme` varchar(60) NOT NULL,
  `PEAssignee` varchar(60) NOT NULL,
  `PEAID` varchar(10) NOT NULL,
  `CreatedOn` varchar(60) NOT NULL,
  `RFQBusUnit` int(5) NOT NULL,
  `NoLinIems` varchar(10) NOT NULL,
  `Comment` text NOT NULL,
  `Ellapes` varchar(10) NOT NULL,
  `OnTQ` int(11) NOT NULL DEFAULT 0,
  `OnTQBy` int(3) NOT NULL,
  `OnTQOn` varchar(30) NOT NULL,
  `DateCreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `projecttask`
--

CREATE TABLE `projecttask` (
  `pID` int(11) NOT NULL,
  `SOCode` text NOT NULL,
  `pName` text NOT NULL,
  `pStart` varchar(24) NOT NULL,
  `pEnd` varchar(24) NOT NULL,
  `pStyle` varchar(30) NOT NULL,
  `pLink` text NOT NULL,
  `pMile` int(2) NOT NULL DEFAULT 0,
  `pRes` varchar(24) NOT NULL,
  `pComp` int(4) NOT NULL DEFAULT 10 COMMENT 'Percentage of Completion',
  `pGroup` int(3) NOT NULL DEFAULT 0 COMMENT 'Number of Task inside you',
  `pParent` int(2) NOT NULL DEFAULT 0 COMMENT 'The Parent Task',
  `pOpen` int(2) NOT NULL DEFAULT 1 COMMENT 'Collapse/Expand State',
  `pDepend` varchar(5) NOT NULL COMMENT 'Task this task is depending on - S @ Start, F @ Finish ',
  `pCaption` text NOT NULL,
  `pNotes` text NOT NULL,
  `CreatedBy` int(4) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `AuditLog` text NOT NULL,
  `isActive` tinyint(4) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchaseinvoice`
--

CREATE TABLE `purchaseinvoice` (
  `siid` int(11) NOT NULL,
  `so` text NOT NULL,
  `CusONo` text NOT NULL,
  `venid` int(10) NOT NULL,
  `InvoiceNo` varchar(60) NOT NULL,
  `OrderNo` varchar(60) NOT NULL,
  `VendorCode` varchar(60) NOT NULL,
  `InvDate` varchar(24) NOT NULL,
  `TermDay` int(5) NOT NULL,
  `Currency` varchar(12) NOT NULL,
  `NGNCRate` varchar(50) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `AuditLog` text NOT NULL,
  `Status` int(11) NOT NULL DEFAULT 1,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchaseinvoicecomm`
--

CREATE TABLE `purchaseinvoicecomm` (
  `siid` int(11) NOT NULL,
  `inovid` text NOT NULL,
  `Description` text NOT NULL,
  `PONum` varchar(60) NOT NULL,
  `cusid` int(6) NOT NULL,
  `DiscountPer` varchar(11) NOT NULL,
  `Nature` varchar(11) NOT NULL,
  `CommID` int(3) NOT NULL,
  `CreatedBy` int(3) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `AuditLog` text NOT NULL,
  `isActive` int(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchaseinvoiceitems`
--

CREATE TABLE `purchaseinvoiceitems` (
  `siid` int(11) NOT NULL,
  `logid` int(6) NOT NULL,
  `snid` int(6) NOT NULL,
  `POCode` text NOT NULL,
  `inovid` text NOT NULL,
  `NGNCRate` varchar(50) NOT NULL,
  `DueDate` varchar(28) NOT NULL,
  `Status` varchar(12) NOT NULL,
  `MatSer` varchar(40) NOT NULL,
  `Description` text NOT NULL,
  `Qty` varchar(11) NOT NULL,
  `UOM` varchar(7) NOT NULL,
  `Currency` varchar(7) NOT NULL,
  `POID` varchar(120) NOT NULL,
  `venid` int(6) NOT NULL,
  `UnitCost` varchar(20) NOT NULL,
  `ExtendedCost` varchar(20) NOT NULL,
  `DiscountPer` varchar(11) NOT NULL,
  `DiscountAmt` varchar(20) NOT NULL,
  `CreatedBy` int(3) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `AuditLog` text NOT NULL,
  `isActive` int(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchaselineitems`
--

CREATE TABLE `purchaselineitems` (
  `LitID` int(11) NOT NULL,
  `POLitID` int(40) NOT NULL,
  `SOCode` text NOT NULL,
  `DueDate` varchar(60) NOT NULL,
  `Status` varchar(13) NOT NULL DEFAULT 'OPEN',
  `BkLog` int(2) NOT NULL DEFAULT 0,
  `MatSer` varchar(60) NOT NULL,
  `Description` text NOT NULL,
  `Remark` text NOT NULL,
  `Qty` varchar(20) NOT NULL,
  `UOM` varchar(10) NOT NULL,
  `SupDetail` text NOT NULL,
  `Price` varchar(60) NOT NULL,
  `Currency` varchar(10) NOT NULL,
  `ConvertRatePerN` varchar(40) NOT NULL,
  `UnitCost` varchar(60) NOT NULL,
  `ExtendedCost` varchar(60) NOT NULL,
  `Discount` varchar(40) NOT NULL,
  `DiscountAmt` varchar(40) NOT NULL,
  `UnitWeight` varchar(40) NOT NULL,
  `ExWeight` varchar(40) NOT NULL,
  `FOBExWorks` varchar(60) NOT NULL,
  `PackingPercent` varchar(5) NOT NULL,
  `ExportPackaging` varchar(60) NOT NULL,
  `InsurePercent` varchar(6) NOT NULL,
  `Insurance` varchar(60) NOT NULL,
  `FreightPercent` varchar(6) NOT NULL,
  `Freight` varchar(60) NOT NULL,
  `aFreight` varchar(30) NOT NULL,
  `UpdatedFreightBy` int(11) NOT NULL,
  `UpdatedFreightOn` varchar(30) NOT NULL,
  `FreightDirect` varchar(15) NOT NULL DEFAULT 'checked',
  `ForeignCost` varchar(60) NOT NULL,
  `HScode` varchar(30) NOT NULL,
  `HsTarrif` varchar(60) NOT NULL,
  `CustomDuty` varchar(60) NOT NULL,
  `CustomSubCharge` varchar(60) NOT NULL,
  `ETLSCharge` varchar(60) NOT NULL,
  `LocalHandling` varchar(60) NOT NULL,
  `aLocalHandling` varchar(30) NOT NULL,
  `UpdatedLocalHandlingBy` int(11) NOT NULL,
  `UpdatedLocalHandlingOn` varchar(30) NOT NULL,
  `pLocalHandling` int(4) NOT NULL,
  `MarkUp` varchar(60) NOT NULL,
  `MarkUpDirect` varchar(23) NOT NULL DEFAULT 'checked',
  `LocalCost` varchar(60) NOT NULL,
  `Currencyv` varchar(20) NOT NULL,
  `EntryDate` varchar(30) NOT NULL,
  `TimeDone` varchar(20) NOT NULL,
  `PreShipmentInspect` varchar(60) NOT NULL,
  `CustomVat` varchar(60) NOT NULL,
  `WHT` varchar(60) NOT NULL,
  `NCD` varchar(60) NOT NULL,
  `UnitDDPrice` varchar(60) NOT NULL,
  `ExDDPrice` varchar(60) NOT NULL,
  `VAT` varchar(60) NOT NULL,
  `BILL` varchar(60) NOT NULL,
  `DELIVERY` varchar(60) NOT NULL,
  `WorkLocation` varchar(60) NOT NULL,
  `DeliveryToWrkLocation` varchar(60) NOT NULL,
  `ExMarkUp` varchar(60) NOT NULL,
  `Customer` text NOT NULL,
  `cusid` int(6) NOT NULL,
  `cusnme` varchar(12) NOT NULL,
  `ProjectControl` int(11) NOT NULL DEFAULT 0,
  `markupperc` varchar(20) NOT NULL,
  `CreatePO` int(2) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `CreatedBy` int(10) NOT NULL,
  `Tech` int(2) NOT NULL,
  `TechCreatedBy` int(5) NOT NULL,
  `MOS` int(2) NOT NULL,
  `MOSCreatedBy` int(5) NOT NULL,
  `Comm` int(2) NOT NULL,
  `CommCreatedBy` int(11) NOT NULL,
  `rate` varchar(20) NOT NULL,
  `per` varchar(20) NOT NULL,
  `EXPPrice` varchar(500) NOT NULL,
  `CIFPPrice` varchar(500) NOT NULL,
  `DPPPrice` varchar(500) NOT NULL,
  `incoterm` varchar(20) NOT NULL,
  `doincoterm` varchar(30) NOT NULL,
  `applydoincoterm` int(2) NOT NULL,
  `Division` text NOT NULL,
  `OnTQ` int(11) NOT NULL DEFAULT 0,
  `OnTQBy` int(11) NOT NULL,
  `OnTQOn` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `purchaseorders`
--

CREATE TABLE `purchaseorders` (
  `cid` int(11) NOT NULL,
  `PONo` text NOT NULL,
  `Comment` text NOT NULL,
  `conDiv` int(2) NOT NULL,
  `PODate` varchar(40) NOT NULL,
  `ENLATTN` int(4) NOT NULL,
  `VendSource` int(3) NOT NULL,
  `ScopeOfSW` text NOT NULL,
  `RaisedBy` int(2) NOT NULL,
  `RaisedOn` int(2) NOT NULL,
  `FileLink` text NOT NULL,
  `Currency` varchar(10) NOT NULL,
  `PDFNUM` varchar(70) NOT NULL,
  `TotalSum` text NOT NULL,
  `LegalOfficer` int(2) NOT NULL,
  `LegalOfficerComment` text NOT NULL,
  `LegalOfficerOn` varchar(60) NOT NULL,
  `AllowDD` int(11) NOT NULL DEFAULT 0,
  `DDAOfficer` int(5) NOT NULL,
  `DDAOfficerComment` text NOT NULL,
  `DDAOfficerOn` varchar(30) NOT NULL,
  `DDOfficer` int(2) NOT NULL,
  `DDOfficerComment` text NOT NULL,
  `DDOfficerOn` varchar(60) NOT NULL,
  `MDOffice` int(2) NOT NULL,
  `MDOfficeComment` text NOT NULL,
  `MDOfficeOn` varchar(60) NOT NULL,
  `AccountOfficer` int(2) NOT NULL,
  `AccountOfficerComment` text NOT NULL,
  `AccountOfficerOn` varchar(60) NOT NULL,
  `isActive` int(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='0';

-- --------------------------------------------------------

--
-- Table structure for table `recentdeletes`
--

CREATE TABLE `recentdeletes` (
  `rdid` int(11) NOT NULL,
  `tncid` int(10) NOT NULL,
  `CounterTrans` text NOT NULL,
  `DoneOn` varchar(40) NOT NULL,
  `DoneBy` int(5) NOT NULL,
  `DelGroup` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reciepts`
--

CREATE TABLE `reciepts` (
  `chid` int(11) NOT NULL,
  `cheuqeNME` text NOT NULL,
  `Bank` text NOT NULL,
  `TranType` varchar(30) NOT NULL,
  `Amt` text NOT NULL,
  `TDate` varchar(35) NOT NULL,
  `CreatedBy` int(2) NOT NULL,
  `CreatedOn` varchar(30) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `regtraining`
--

CREATE TABLE `regtraining` (
  `tid` int(11) NOT NULL,
  `userid` int(6) NOT NULL,
  `Title` text NOT NULL,
  `Trainer` text NOT NULL,
  `Venue` text NOT NULL,
  `Duration` text NOT NULL,
  `StartDate` text NOT NULL,
  `RegisteredOn` varchar(40) NOT NULL,
  `RegisteredBy` int(5) NOT NULL,
  `Remark` text NOT NULL,
  `Attended` int(2) NOT NULL DEFAULT 0,
  `isActive` int(2) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reqcategory`
--

CREATE TABLE `reqcategory` (
  `id` int(11) NOT NULL,
  `CategoryName` text NOT NULL,
  `ShortCode` varchar(10) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rfq`
--

CREATE TABLE `rfq` (
  `RFQid` int(11) NOT NULL,
  `RFQNum` varchar(40) NOT NULL,
  `MirriorRFQ` varchar(40) NOT NULL,
  `RFQUpdate` text NOT NULL,
  `Status` varchar(40) DEFAULT NULL,
  `Customer` varchar(60) NOT NULL,
  `cusid` int(11) NOT NULL,
  `Attention` text NOT NULL,
  `Scope` varchar(15) NOT NULL,
  `DateStart` varchar(30) NOT NULL,
  `DateEnd` varchar(30) NOT NULL,
  `Source` varchar(10) NOT NULL,
  `Currency` varchar(30) NOT NULL,
  `Attachment` text NOT NULL,
  `CompanyRefNo` varchar(20) NOT NULL,
  `PENjobCode` varchar(30) NOT NULL,
  `BuyersNme` varchar(60) NOT NULL,
  `PEAssignee` varchar(60) NOT NULL,
  `PEAID` varchar(10) NOT NULL,
  `CreatedOn` varchar(60) NOT NULL,
  `RFQBusUnit` int(5) NOT NULL,
  `NoLinIems` varchar(10) NOT NULL,
  `Comment` text NOT NULL,
  `Ellapes` varchar(10) NOT NULL,
  `OnTQ` int(11) NOT NULL DEFAULT 0,
  `OnTQBy` int(3) NOT NULL,
  `OnTQOn` varchar(30) NOT NULL,
  `DateCreated` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salesinvoice`
--

CREATE TABLE `salesinvoice` (
  `siid` int(11) NOT NULL,
  `so` text NOT NULL,
  `cusid` int(10) NOT NULL,
  `InvoiceNo` varchar(60) NOT NULL,
  `InvoDate` varchar(24) NOT NULL,
  `TermDay` int(3) NOT NULL,
  `OrderNo` varchar(60) NOT NULL,
  `SONum` text NOT NULL,
  `CusONo` text NOT NULL,
  `Status` int(3) NOT NULL DEFAULT 1,
  `VendorCode` varchar(60) NOT NULL,
  `Currency` varchar(12) NOT NULL,
  `NGNCRate` varchar(50) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `AuditLog` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salesinvoicecomm`
--

CREATE TABLE `salesinvoicecomm` (
  `siid` int(11) NOT NULL,
  `inovid` text NOT NULL,
  `Description` text NOT NULL,
  `CusONo` varchar(60) NOT NULL,
  `cusid` int(6) NOT NULL,
  `DiscountPer` varchar(11) NOT NULL,
  `CreatedBy` int(3) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `AuditLog` text NOT NULL,
  `isActive` int(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `salesinvoiceitems`
--

CREATE TABLE `salesinvoiceitems` (
  `siid` int(11) NOT NULL,
  `purid` int(6) NOT NULL,
  `snid` int(6) NOT NULL,
  `SOCode` text NOT NULL,
  `inovid` text NOT NULL,
  `NGNCRate` varchar(50) NOT NULL,
  `DueDate` varchar(28) NOT NULL,
  `Status` varchar(12) NOT NULL,
  `MatSer` varchar(40) NOT NULL,
  `Description` text NOT NULL,
  `Qty` varchar(11) NOT NULL,
  `UOM` varchar(7) NOT NULL,
  `Currency` varchar(7) NOT NULL,
  `CusONo` varchar(60) NOT NULL,
  `Customer` text NOT NULL,
  `cusnme` varchar(10) NOT NULL,
  `cusid` int(6) NOT NULL,
  `UnitCost` varchar(20) NOT NULL,
  `ExtendedCost` varchar(20) NOT NULL,
  `DiscountPer` varchar(11) NOT NULL,
  `DiscountAmt` varchar(20) NOT NULL,
  `CreatedBy` int(3) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `AuditLog` text NOT NULL,
  `isActive` int(3) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `setpost`
--

CREATE TABLE `setpost` (
  `tncid` int(11) NOT NULL,
  `REQCODE` varchar(30) NOT NULL,
  `mItem` int(2) NOT NULL DEFAULT 0,
  `mJob` int(5) NOT NULL,
  `CHRID` varchar(14) NOT NULL,
  `ItemQty` int(30) NOT NULL,
  `EquipC` int(4) NOT NULL,
  `BankAccount` int(5) NOT NULL,
  `ChqNo` varchar(30) NOT NULL,
  `ReceivedBy` varchar(10) NOT NULL,
  `GLImpacted` int(5) NOT NULL,
  `GLDescription` text NOT NULL,
  `GLDescriptionPB` text NOT NULL,
  `TransactionAmount` varchar(30) NOT NULL,
  `PostedAmount` varchar(30) NOT NULL,
  `TransacType` varchar(10) NOT NULL,
  `CounterTrans` varchar(60) NOT NULL,
  `TransactionDate` varchar(30) NOT NULL,
  `Remark` text NOT NULL,
  `CostRevenueCenter` int(5) NOT NULL,
  `VendorID` int(5) NOT NULL,
  `VINVOICE` text NOT NULL,
  `CusID` int(12) NOT NULL,
  `ENLINVOICE` varchar(12) NOT NULL,
  `StaffID` int(5) NOT NULL,
  `Currency` varchar(15) NOT NULL,
  `NGNTCURR` varchar(30) NOT NULL,
  `CRCenter` int(5) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `PostedBy` int(5) NOT NULL,
  `PostedOn` varchar(30) NOT NULL,
  `RptType` varchar(140) NOT NULL,
  `RptType1` text NOT NULL,
  `DelLog` text NOT NULL,
  `UpdateLog` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `setpostgpig`
--

CREATE TABLE `setpostgpig` (
  `tncid` int(11) NOT NULL,
  `REQCODE` varchar(30) NOT NULL,
  `mItem` int(2) NOT NULL DEFAULT 0,
  `mJob` int(5) NOT NULL,
  `CHRID` varchar(14) NOT NULL,
  `ItemQty` int(30) NOT NULL,
  `EquipC` int(4) NOT NULL,
  `BankAccount` int(5) NOT NULL,
  `ChqNo` varchar(30) NOT NULL,
  `ReceivedBy` varchar(10) NOT NULL,
  `GLImpacted` int(5) NOT NULL,
  `GLDescription` text NOT NULL,
  `GLDescriptionPB` text NOT NULL,
  `TransactionAmount` varchar(30) NOT NULL,
  `PostedAmount` varchar(30) NOT NULL,
  `TransacType` varchar(10) NOT NULL,
  `CounterTrans` varchar(60) NOT NULL,
  `TransactionDate` varchar(30) NOT NULL,
  `Remark` text NOT NULL,
  `CostRevenueCenter` int(5) NOT NULL,
  `VendorID` int(5) NOT NULL,
  `VINVOICE` text NOT NULL,
  `CusID` int(12) NOT NULL,
  `ENLINVOICE` varchar(12) NOT NULL,
  `StaffID` int(5) NOT NULL,
  `Currency` varchar(15) NOT NULL,
  `NGNTCURR` varchar(30) NOT NULL,
  `CRCenter` int(5) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `PostedBy` int(5) NOT NULL,
  `PostedOn` varchar(30) NOT NULL,
  `RptType` varchar(140) NOT NULL,
  `RptType1` text NOT NULL,
  `DelLog` text NOT NULL,
  `UpdateLog` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `so`
--

CREATE TABLE `so` (
  `poID` int(11) NOT NULL,
  `SOType` int(2) NOT NULL DEFAULT 1,
  `SONum` text NOT NULL,
  `CusONo` varchar(30) NOT NULL,
  `Status` varchar(30) NOT NULL,
  `Customer` varchar(80) NOT NULL,
  `cusid` int(6) NOT NULL,
  `cusnme` varchar(12) NOT NULL,
  `StaffID` varchar(60) NOT NULL,
  `ItemsN` varchar(10) NOT NULL,
  `ItemsDetails` text NOT NULL,
  `SubTotal` varchar(24) NOT NULL,
  `pTax` int(10) NOT NULL,
  `Tax` varchar(24) NOT NULL,
  `Total` varchar(50) NOT NULL,
  `SOdate` varchar(20) NOT NULL,
  `SOLocation` text NOT NULL,
  `SOAssignStaff` varchar(30) NOT NULL,
  `ItemList` text NOT NULL,
  `Attachment` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `stockhistory`
--

CREATE TABLE `stockhistory` (
  `shid` int(11) NOT NULL,
  `sid` int(10) NOT NULL,
  `actiondate` varchar(60) NOT NULL,
  `stockcode` varchar(60) NOT NULL,
  `station` int(4) NOT NULL,
  `storage` int(4) NOT NULL,
  `itemcat` int(4) NOT NULL,
  `Description` text NOT NULL,
  `Bin` int(4) NOT NULL,
  `Bal` int(4) NOT NULL,
  `Condi` varchar(60) NOT NULL,
  `Amt` varchar(30) NOT NULL,
  `purpose` text NOT NULL,
  `action` text NOT NULL,
  `actor` int(10) NOT NULL,
  `newstate` text NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `RecDate` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supid` int(11) NOT NULL,
  `POCOUNT` int(34) NOT NULL,
  `SupDir` text NOT NULL,
  `SupSCode` varchar(10) NOT NULL,
  `SupYrReg` text NOT NULL,
  `SupENLRegNo` text NOT NULL,
  `SupLevel` text NOT NULL,
  `SupCore` text NOT NULL,
  `SupCat` text NOT NULL,
  `SupNme` text NOT NULL,
  `SupAddress` text NOT NULL,
  `SupCountry` text NOT NULL,
  `SupEMail` varchar(40) NOT NULL,
  `SupPhone1` varchar(24) NOT NULL,
  `SupPhone2` varchar(24) NOT NULL,
  `SupRefNo` varchar(30) NOT NULL,
  `SupTIN` varchar(20) NOT NULL,
  `SupGL` int(3) NOT NULL,
  `SupURL` text NOT NULL,
  `SupBusD` text NOT NULL,
  `Status` varchar(20) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `CreatedOn` varchar(33) NOT NULL,
  `CreatedBy` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `supportingdoc`
--

CREATE TABLE `supportingdoc` (
  `sdid` int(11) NOT NULL,
  `link` text NOT NULL,
  `description` text NOT NULL,
  `title` text NOT NULL,
  `addedby` int(2) NOT NULL,
  `addedon` varchar(60) NOT NULL,
  `module` varchar(100) NOT NULL,
  `docid` int(5) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `survey`
--

CREATE TABLE `survey` (
  `sid` int(11) NOT NULL,
  `uid` int(7) NOT NULL,
  `Q1` int(3) NOT NULL,
  `Q2` int(3) NOT NULL,
  `Q3` int(11) NOT NULL,
  `Q4` int(11) NOT NULL,
  `Q5` int(11) NOT NULL,
  `Q6` int(11) NOT NULL,
  `Q7` int(11) NOT NULL,
  `Q8` int(11) NOT NULL,
  `observation` text NOT NULL,
  `recommendation` text NOT NULL,
  `CreatedOn` varchar(37) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sysvar`
--

CREATE TABLE `sysvar` (
  `id` int(11) NOT NULL,
  `variableName` text NOT NULL,
  `variableValue` text NOT NULL,
  `updateaudit` text NOT NULL,
  `deleteaudit` text NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `terms`
--

CREATE TABLE `terms` (
  `termsID` int(11) NOT NULL,
  `Terms` text NOT NULL,
  `Title` varchar(60) NOT NULL,
  `CreatedBy` varchar(20) NOT NULL,
  `CreatedOn` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `uom`
--

CREATE TABLE `uom` (
  `UOMid` int(11) NOT NULL,
  `UOMNme` varchar(40) NOT NULL,
  `UOMAbbr` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userext`
--

CREATE TABLE `userext` (
  `uid` int(11) NOT NULL,
  `username` varchar(60) NOT NULL,
  `CRMemail` varchar(125) NOT NULL,
  `password` varchar(60) NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `CustomerID` int(11) NOT NULL,
  `CreatedBy` int(11) NOT NULL,
  `CreatedOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `uid` int(11) NOT NULL,
  `StaffID` varchar(60) NOT NULL,
  `DeptID` int(5) NOT NULL,
  `Dept` varchar(60) NOT NULL DEFAULT 'User',
  `AccessModule` text NOT NULL,
  `ReciNotify` int(2) NOT NULL DEFAULT 0,
  `Password` varchar(60) NOT NULL,
  `Role` varchar(60) NOT NULL DEFAULT 'user',
  `porApproval` int(11) NOT NULL DEFAULT 0,
  `Supervisor` int(11) NOT NULL DEFAULT 0,
  `HDept` int(2) NOT NULL DEFAULT 0,
  `HDiv` int(2) NOT NULL DEFAULT 0,
  `Mgr` int(2) NOT NULL DEFAULT 0,
  `CEO` int(2) NOT NULL DEFAULT 0,
  `COO` int(3) NOT NULL DEFAULT 0,
  `rptQMI` int(11) NOT NULL DEFAULT 1,
  `viewQMI` int(11) NOT NULL DEFAULT 1,
  `Firstname` varchar(60) NOT NULL,
  `Middlename` varchar(60) NOT NULL,
  `Surname` varchar(60) NOT NULL,
  `Gender` varchar(12) NOT NULL,
  `Email` varchar(60) NOT NULL,
  `Phone` varchar(34) NOT NULL,
  `DoB` varchar(14) NOT NULL,
  `LastPaymentDate` varchar(34) NOT NULL,
  `DateReg` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Picture` longblob NOT NULL,
  `Signature` longblob NOT NULL,
  `ModeOfEmp` varchar(24) NOT NULL,
  `BusinessUnit` varchar(30) NOT NULL,
  `JobTitle` varchar(24) NOT NULL,
  `JobPosition` varchar(24) NOT NULL,
  `RptMgr` int(3) NOT NULL,
  `EmployeeStatus` varchar(24) NOT NULL,
  `DateOfJoining` varchar(27) NOT NULL,
  `YearsOfExp` int(3) NOT NULL,
  `WorkExt` varchar(9) NOT NULL,
  `WorkPhone` varchar(30) NOT NULL,
  `isActive` tinyint(4) NOT NULL,
  `isAvalible` int(11) NOT NULL DEFAULT 1,
  `BankID` int(4) NOT NULL,
  `AccountType` varchar(60) NOT NULL,
  `AccountNumber` varchar(20) NOT NULL,
  `GrossSalary` varchar(40) NOT NULL,
  `PayrollElem` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `vendorsinvoices`
--

CREATE TABLE `vendorsinvoices` (
  `cid` int(11) NOT NULL,
  `IVNo` text NOT NULL,
  `Comment` text NOT NULL,
  `conDiv` int(2) NOT NULL,
  `IVDate` varchar(40) NOT NULL,
  `ENLATTN` int(4) NOT NULL,
  `VENATTN` text NOT NULL,
  `VendSource` int(3) NOT NULL,
  `ScopeOfSW` text NOT NULL,
  `RaisedBy` int(2) NOT NULL,
  `RaisedOn` int(2) NOT NULL,
  `FileLink` text NOT NULL,
  `Currency` varchar(10) NOT NULL,
  `PDFNUM` varchar(70) NOT NULL,
  `PONUM` text NOT NULL,
  `CnPAppComment` text NOT NULL,
  `CnPAppOn` varchar(34) NOT NULL,
  `CnPApp` int(5) NOT NULL,
  `LegalOfficer` int(2) NOT NULL,
  `LegalOfficerComment` text NOT NULL,
  `LegalOfficerOn` varchar(60) NOT NULL,
  `GMCSAppDate` varchar(30) NOT NULL,
  `GMCSAppComment` text NOT NULL,
  `GMCSApp` int(5) NOT NULL,
  `AllowDD` int(11) NOT NULL DEFAULT 0,
  `DDOfficer` int(2) NOT NULL,
  `DDOfficerComment` text NOT NULL,
  `DDOfficerOn` varchar(60) NOT NULL,
  `GMCSAppStatus` int(2) NOT NULL DEFAULT 0,
  `DDAppStatus` int(2) NOT NULL DEFAULT 0,
  `MDAppStatus` int(2) NOT NULL DEFAULT 0,
  `MDOffice` int(2) NOT NULL,
  `MDOfficeComment` text NOT NULL,
  `MDOfficeOn` varchar(60) NOT NULL,
  `AccountOfficer` int(2) NOT NULL,
  `AccountOfficerComment` text NOT NULL,
  `AccountOfficerOn` varchar(60) NOT NULL,
  `SETR` int(2) NOT NULL DEFAULT 0,
  `SERLog` text NOT NULL,
  `isActive` int(2) NOT NULL DEFAULT 1,
  `NGNRate` varchar(30) NOT NULL,
  `BnkID` int(4) NOT NULL,
  `CRDGL` varchar(10) NOT NULL,
  `PostedOn` varchar(30) NOT NULL,
  `PostID` int(5) NOT NULL,
  `PostedBy` int(5) NOT NULL,
  `Paid` int(2) NOT NULL DEFAULT 0,
  `PaidBy` int(5) NOT NULL,
  `PaidOn` varchar(32) NOT NULL,
  `COOApp` int(7) NOT NULL,
  `COOAppDate` varchar(32) NOT NULL,
  `COOAppComment` text NOT NULL,
  `COOAppStatus` int(2) NOT NULL DEFAULT 0,
  `Status` varchar(40) NOT NULL,
  `StatusLog` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci COMMENT='0';

-- --------------------------------------------------------

--
-- Table structure for table `wh_bins`
--

CREATE TABLE `wh_bins` (
  `account_code` varchar(11) NOT NULL,
  `account_code2` varchar(15) NOT NULL DEFAULT '',
  `account_name` varchar(60) NOT NULL DEFAULT '',
  `account_type` varchar(10) NOT NULL DEFAULT '0',
  `isActive` tinyint(1) NOT NULL DEFAULT 1,
  `mid` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wh_stations`
--

CREATE TABLE `wh_stations` (
  `cid` int(3) NOT NULL,
  `station_name` varchar(60) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `ctype` tinyint(1) NOT NULL DEFAULT 0,
  `isActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wh_stock`
--

CREATE TABLE `wh_stock` (
  `sid` int(11) NOT NULL,
  `stockcode` varchar(60) NOT NULL,
  `station` int(5) NOT NULL,
  `storage` int(5) NOT NULL,
  `itemcat` int(3) NOT NULL,
  `Description` text NOT NULL,
  `Bin` int(4) NOT NULL,
  `Bal` int(11) NOT NULL,
  `Issued` int(11) NOT NULL,
  `Condi` varchar(50) NOT NULL DEFAULT 'GOOD',
  `TotalAmt` varchar(30) NOT NULL,
  `datereg` varchar(60) NOT NULL,
  `regby` int(3) NOT NULL,
  `auditlog` text NOT NULL,
  `isActive` int(11) NOT NULL DEFAULT 1,
  `RecDate` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wh_storages`
--

CREATE TABLE `wh_storages` (
  `id` int(10) NOT NULL,
  `name` varchar(60) NOT NULL DEFAULT '',
  `class_id` varchar(3) NOT NULL DEFAULT '',
  `parent` varchar(10) NOT NULL DEFAULT '-1',
  `isActive` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accountinvoice`
--
ALTER TABLE `accountinvoice`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `acct_ivitems`
--
ALTER TABLE `acct_ivitems`
  ADD PRIMARY KEY (`poitid`);

--
-- Indexes for table `acct_ivmiscellaneous`
--
ALTER TABLE `acct_ivmiscellaneous`
  ADD PRIMARY KEY (`poitid`);

--
-- Indexes for table `acct_vendorsinvoices`
--
ALTER TABLE `acct_vendorsinvoices`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `acc_chart_class`
--
ALTER TABLE `acc_chart_class`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `acc_chart_master`
--
ALTER TABLE `acc_chart_master`
  ADD PRIMARY KEY (`mid`),
  ADD KEY `account_name` (`account_name`),
  ADD KEY `accounts_by_type` (`account_type`,`account_code`);

--
-- Indexes for table `acc_chart_types`
--
ALTER TABLE `acc_chart_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `class_id` (`class_id`);

--
-- Indexes for table `acc_settings`
--
ALTER TABLE `acc_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bankaccount`
--
ALTER TABLE `bankaccount`
  ADD PRIMARY KEY (`baccid`);

--
-- Indexes for table `bankpayment`
--
ALTER TABLE `bankpayment`
  ADD PRIMARY KEY (`siid`);

--
-- Indexes for table `banks`
--
ALTER TABLE `banks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `budget_expected`
--
ALTER TABLE `budget_expected`
  ADD PRIMARY KEY (`deid`);

--
-- Indexes for table `businessunit`
--
ALTER TABLE `businessunit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `calibration_log`
--
ALTER TABLE `calibration_log`
  ADD PRIMARY KEY (`calid`);

--
-- Indexes for table `cashreq`
--
ALTER TABLE `cashreq`
  ADD PRIMARY KEY (`reqid`);

--
-- Indexes for table `cheuqes`
--
ALTER TABLE `cheuqes`
  ADD PRIMARY KEY (`chid`);

--
-- Indexes for table `compcontri_settings`
--
ALTER TABLE `compcontri_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contracts`
--
ALTER TABLE `contracts`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `crmlitfeedback`
--
ALTER TABLE `crmlitfeedback`
  ADD PRIMARY KEY (`crmLITfbID`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`curID`);

--
-- Indexes for table `cuspo`
--
ALTER TABLE `cuspo`
  ADD PRIMARY KEY (`CUSPOid`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`cusid`);

--
-- Indexes for table `deductions_settings`
--
ALTER TABLE `deductions_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `divisions`
--
ALTER TABLE `divisions`
  ADD PRIMARY KEY (`divid`);

--
-- Indexes for table `dmcuspo`
--
ALTER TABLE `dmcuspo`
  ADD PRIMARY KEY (`CUSPOid`);

--
-- Indexes for table `dmrfq`
--
ALTER TABLE `dmrfq`
  ADD PRIMARY KEY (`RFQid`);

--
-- Indexes for table `docclass`
--
ALTER TABLE `docclass`
  ADD PRIMARY KEY (`sdid`);

--
-- Indexes for table `docs`
--
ALTER TABLE `docs`
  ADD PRIMARY KEY (`lactid`);

--
-- Indexes for table `earnings_settings`
--
ALTER TABLE `earnings_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `emailtb`
--
ALTER TABLE `emailtb`
  ADD PRIMARY KEY (`emailid`);

--
-- Indexes for table `empcontacts`
--
ALTER TABLE `empcontacts`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `empdocuments`
--
ALTER TABLE `empdocuments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `empeducation`
--
ALTER TABLE `empeducation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `empjobhistory`
--
ALTER TABLE `empjobhistory`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `empleave`
--
ALTER TABLE `empleave`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `empmedi`
--
ALTER TABLE `empmedi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `empskills`
--
ALTER TABLE `empskills`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `emptravel`
--
ALTER TABLE `emptravel`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enlinvoices`
--
ALTER TABLE `enlinvoices`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `enlivitems`
--
ALTER TABLE `enlivitems`
  ADD PRIMARY KEY (`poitid`);

--
-- Indexes for table `enlivmiscellaneous`
--
ALTER TABLE `enlivmiscellaneous`
  ADD PRIMARY KEY (`poitid`);

--
-- Indexes for table `epcprojectdetails`
--
ALTER TABLE `epcprojectdetails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `equipments`
--
ALTER TABLE `equipments`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `equip_category`
--
ALTER TABLE `equip_category`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `equip_manufacturers`
--
ALTER TABLE `equip_manufacturers`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `equip_stations`
--
ALTER TABLE `equip_stations`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `equip_subcategory`
--
ALTER TABLE `equip_subcategory`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `filereq`
--
ALTER TABLE `filereq`
  ADD PRIMARY KEY (`fid`);

--
-- Indexes for table `gl_entries`
--
ALTER TABLE `gl_entries`
  ADD PRIMARY KEY (`eid`);

--
-- Indexes for table `hir`
--
ALTER TABLE `hir`
  ADD PRIMARY KEY (`hirid`);

--
-- Indexes for table `historylineitem`
--
ALTER TABLE `historylineitem`
  ADD PRIMARY KEY (`hlID`);

--
-- Indexes for table `hse_kpi`
--
ALTER TABLE `hse_kpi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `class_id` (`class_name`);

--
-- Indexes for table `hse_kpi_data`
--
ALTER TABLE `hse_kpi_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ictreq`
--
ALTER TABLE `ictreq`
  ADD PRIMARY KEY (`reqid`);

--
-- Indexes for table `internalauditactivities`
--
ALTER TABLE `internalauditactivities`
  ADD PRIMARY KEY (`lactid`);

--
-- Indexes for table `internalauditsubjects`
--
ALTER TABLE `internalauditsubjects`
  ADD PRIMARY KEY (`sdid`);

--
-- Indexes for table `itemcategory`
--
ALTER TABLE `itemcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ivitems`
--
ALTER TABLE `ivitems`
  ADD PRIMARY KEY (`poitid`);

--
-- Indexes for table `ivmiscellaneous`
--
ALTER TABLE `ivmiscellaneous`
  ADD PRIMARY KEY (`poitid`);

--
-- Indexes for table `jettyequipments`
--
ALTER TABLE `jettyequipments`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `jettyreport`
--
ALTER TABLE `jettyreport`
  ADD PRIMARY KEY (`jid`);

--
-- Indexes for table `jha`
--
ALTER TABLE `jha`
  ADD PRIMARY KEY (`jhaid`);

--
-- Indexes for table `jobposition`
--
ALTER TABLE `jobposition`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`chid`);

--
-- Indexes for table `jobtitle`
--
ALTER TABLE `jobtitle`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `legalactivities`
--
ALTER TABLE `legalactivities`
  ADD PRIMARY KEY (`lactid`);

--
-- Indexes for table `legalmeetings`
--
ALTER TABLE `legalmeetings`
  ADD PRIMARY KEY (`sdid`);

--
-- Indexes for table `legalsubjects`
--
ALTER TABLE `legalsubjects`
  ADD PRIMARY KEY (`sdid`);

--
-- Indexes for table `lineitems`
--
ALTER TABLE `lineitems`
  ADD PRIMARY KEY (`LitID`);

--
-- Indexes for table `logistics`
--
ALTER TABLE `logistics`
  ADD PRIMARY KEY (`logID`);

--
-- Indexes for table `maintain_activities`
--
ALTER TABLE `maintain_activities`
  ADD PRIMARY KEY (`maid`);

--
-- Indexes for table `mljobs`
--
ALTER TABLE `mljobs`
  ADD PRIMARY KEY (`JOBid`);

--
-- Indexes for table `msg`
--
ALTER TABLE `msg`
  ADD PRIMARY KEY (`msgid`);

--
-- Indexes for table `noncon`
--
ALTER TABLE `noncon`
  ADD PRIMARY KEY (`nid`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`noteID`);

--
-- Indexes for table `npo`
--
ALTER TABLE `npo`
  ADD PRIMARY KEY (`RFQid`);

--
-- Indexes for table `opt_cal_method`
--
ALTER TABLE `opt_cal_method`
  ADD PRIMARY KEY (`calid`);

--
-- Indexes for table `opt_earning_freq`
--
ALTER TABLE `opt_earning_freq`
  ADD PRIMARY KEY (`enfreqid`);

--
-- Indexes for table `opt_employee_group`
--
ALTER TABLE `opt_employee_group`
  ADD PRIMARY KEY (`empgid`);

--
-- Indexes for table `otherreceiver`
--
ALTER TABLE `otherreceiver`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `payrollelement`
--
ALTER TABLE `payrollelement`
  ADD PRIMARY KEY (`payid`);

--
-- Indexes for table `payrollsettings`
--
ALTER TABLE `payrollsettings`
  ADD PRIMARY KEY (`pyid`);

--
-- Indexes for table `pecheques`
--
ALTER TABLE `pecheques`
  ADD PRIMARY KEY (`pechq`);

--
-- Indexes for table `po`
--
ALTER TABLE `po`
  ADD PRIMARY KEY (`poID`);

--
-- Indexes for table `poinfo`
--
ALTER TABLE `poinfo`
  ADD PRIMARY KEY (`POinfoID`);

--
-- Indexes for table `poinfocomm`
--
ALTER TABLE `poinfocomm`
  ADD PRIMARY KEY (`POinfocommID`);

--
-- Indexes for table `poinfolineitem`
--
ALTER TABLE `poinfolineitem`
  ADD PRIMARY KEY (`POinfoID`);

--
-- Indexes for table `poitems`
--
ALTER TABLE `poitems`
  ADD PRIMARY KEY (`poitid`);

--
-- Indexes for table `polineitems`
--
ALTER TABLE `polineitems`
  ADD PRIMARY KEY (`LitID`);

--
-- Indexes for table `pomiscellaneous`
--
ALTER TABLE `pomiscellaneous`
  ADD PRIMARY KEY (`poitid`);

--
-- Indexes for table `poreq`
--
ALTER TABLE `poreq`
  ADD PRIMARY KEY (`reqid`);

--
-- Indexes for table `postings`
--
ALTER TABLE `postings`
  ADD PRIMARY KEY (`tncid`);

--
-- Indexes for table `postingsnew`
--
ALTER TABLE `postingsnew`
  ADD PRIMARY KEY (`tncid`);

--
-- Indexes for table `posting_update`
--
ALTER TABLE `posting_update`
  ADD PRIMARY KEY (`puid`);

--
-- Indexes for table `ppe_kit`
--
ALTER TABLE `ppe_kit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `projdeliverables`
--
ALTER TABLE `projdeliverables`
  ADD PRIMARY KEY (`LitID`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`PROJid`);

--
-- Indexes for table `projecttask`
--
ALTER TABLE `projecttask`
  ADD PRIMARY KEY (`pID`);

--
-- Indexes for table `purchaseinvoice`
--
ALTER TABLE `purchaseinvoice`
  ADD PRIMARY KEY (`siid`);

--
-- Indexes for table `purchaseinvoicecomm`
--
ALTER TABLE `purchaseinvoicecomm`
  ADD PRIMARY KEY (`siid`);

--
-- Indexes for table `purchaseinvoiceitems`
--
ALTER TABLE `purchaseinvoiceitems`
  ADD PRIMARY KEY (`siid`);

--
-- Indexes for table `purchaselineitems`
--
ALTER TABLE `purchaselineitems`
  ADD PRIMARY KEY (`LitID`);

--
-- Indexes for table `purchaseorders`
--
ALTER TABLE `purchaseorders`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `recentdeletes`
--
ALTER TABLE `recentdeletes`
  ADD PRIMARY KEY (`rdid`);

--
-- Indexes for table `reciepts`
--
ALTER TABLE `reciepts`
  ADD PRIMARY KEY (`chid`);

--
-- Indexes for table `regtraining`
--
ALTER TABLE `regtraining`
  ADD PRIMARY KEY (`tid`);

--
-- Indexes for table `reqcategory`
--
ALTER TABLE `reqcategory`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `rfq`
--
ALTER TABLE `rfq`
  ADD PRIMARY KEY (`RFQid`);

--
-- Indexes for table `salesinvoice`
--
ALTER TABLE `salesinvoice`
  ADD PRIMARY KEY (`siid`);

--
-- Indexes for table `salesinvoicecomm`
--
ALTER TABLE `salesinvoicecomm`
  ADD PRIMARY KEY (`siid`);

--
-- Indexes for table `salesinvoiceitems`
--
ALTER TABLE `salesinvoiceitems`
  ADD PRIMARY KEY (`siid`);

--
-- Indexes for table `setpost`
--
ALTER TABLE `setpost`
  ADD PRIMARY KEY (`tncid`);

--
-- Indexes for table `setpostgpig`
--
ALTER TABLE `setpostgpig`
  ADD PRIMARY KEY (`tncid`);

--
-- Indexes for table `so`
--
ALTER TABLE `so`
  ADD PRIMARY KEY (`poID`);

--
-- Indexes for table `stockhistory`
--
ALTER TABLE `stockhistory`
  ADD PRIMARY KEY (`shid`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supid`);

--
-- Indexes for table `supportingdoc`
--
ALTER TABLE `supportingdoc`
  ADD PRIMARY KEY (`sdid`);

--
-- Indexes for table `survey`
--
ALTER TABLE `survey`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `sysvar`
--
ALTER TABLE `sysvar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `terms`
--
ALTER TABLE `terms`
  ADD PRIMARY KEY (`termsID`);

--
-- Indexes for table `uom`
--
ALTER TABLE `uom`
  ADD PRIMARY KEY (`UOMid`);

--
-- Indexes for table `userext`
--
ALTER TABLE `userext`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `vendorsinvoices`
--
ALTER TABLE `vendorsinvoices`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `wh_bins`
--
ALTER TABLE `wh_bins`
  ADD PRIMARY KEY (`mid`),
  ADD KEY `account_name` (`account_name`),
  ADD KEY `accounts_by_type` (`account_type`,`account_code`);

--
-- Indexes for table `wh_stations`
--
ALTER TABLE `wh_stations`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `wh_stock`
--
ALTER TABLE `wh_stock`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `wh_storages`
--
ALTER TABLE `wh_storages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `name` (`name`),
  ADD KEY `class_id` (`class_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accountinvoice`
--
ALTER TABLE `accountinvoice`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acct_ivitems`
--
ALTER TABLE `acct_ivitems`
  MODIFY `poitid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acct_ivmiscellaneous`
--
ALTER TABLE `acct_ivmiscellaneous`
  MODIFY `poitid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acct_vendorsinvoices`
--
ALTER TABLE `acct_vendorsinvoices`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acc_chart_class`
--
ALTER TABLE `acc_chart_class`
  MODIFY `cid` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acc_chart_master`
--
ALTER TABLE `acc_chart_master`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acc_chart_types`
--
ALTER TABLE `acc_chart_types`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `acc_settings`
--
ALTER TABLE `acc_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bankaccount`
--
ALTER TABLE `bankaccount`
  MODIFY `baccid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bankpayment`
--
ALTER TABLE `bankpayment`
  MODIFY `siid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `banks`
--
ALTER TABLE `banks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `budget_expected`
--
ALTER TABLE `budget_expected`
  MODIFY `deid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `businessunit`
--
ALTER TABLE `businessunit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `calibration_log`
--
ALTER TABLE `calibration_log`
  MODIFY `calid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cashreq`
--
ALTER TABLE `cashreq`
  MODIFY `reqid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cheuqes`
--
ALTER TABLE `cheuqes`
  MODIFY `chid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `compcontri_settings`
--
ALTER TABLE `compcontri_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contracts`
--
ALTER TABLE `contracts`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `crmlitfeedback`
--
ALTER TABLE `crmlitfeedback`
  MODIFY `crmLITfbID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `curID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cuspo`
--
ALTER TABLE `cuspo`
  MODIFY `CUSPOid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `cusid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `deductions_settings`
--
ALTER TABLE `deductions_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `divisions`
--
ALTER TABLE `divisions`
  MODIFY `divid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dmcuspo`
--
ALTER TABLE `dmcuspo`
  MODIFY `CUSPOid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dmrfq`
--
ALTER TABLE `dmrfq`
  MODIFY `RFQid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `docclass`
--
ALTER TABLE `docclass`
  MODIFY `sdid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `docs`
--
ALTER TABLE `docs`
  MODIFY `lactid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `earnings_settings`
--
ALTER TABLE `earnings_settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emailtb`
--
ALTER TABLE `emailtb`
  MODIFY `emailid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `empcontacts`
--
ALTER TABLE `empcontacts`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `empdocuments`
--
ALTER TABLE `empdocuments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `empeducation`
--
ALTER TABLE `empeducation`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `empjobhistory`
--
ALTER TABLE `empjobhistory`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `empleave`
--
ALTER TABLE `empleave`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `empmedi`
--
ALTER TABLE `empmedi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `empskills`
--
ALTER TABLE `empskills`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `emptravel`
--
ALTER TABLE `emptravel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enlinvoices`
--
ALTER TABLE `enlinvoices`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enlivitems`
--
ALTER TABLE `enlivitems`
  MODIFY `poitid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `enlivmiscellaneous`
--
ALTER TABLE `enlivmiscellaneous`
  MODIFY `poitid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `epcprojectdetails`
--
ALTER TABLE `epcprojectdetails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `equipments`
--
ALTER TABLE `equipments`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `equip_category`
--
ALTER TABLE `equip_category`
  MODIFY `cid` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `equip_manufacturers`
--
ALTER TABLE `equip_manufacturers`
  MODIFY `cid` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `equip_stations`
--
ALTER TABLE `equip_stations`
  MODIFY `cid` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `equip_subcategory`
--
ALTER TABLE `equip_subcategory`
  MODIFY `cid` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `filereq`
--
ALTER TABLE `filereq`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gl_entries`
--
ALTER TABLE `gl_entries`
  MODIFY `eid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hir`
--
ALTER TABLE `hir`
  MODIFY `hirid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `historylineitem`
--
ALTER TABLE `historylineitem`
  MODIFY `hlID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hse_kpi`
--
ALTER TABLE `hse_kpi`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hse_kpi_data`
--
ALTER TABLE `hse_kpi_data`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ictreq`
--
ALTER TABLE `ictreq`
  MODIFY `reqid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `internalauditactivities`
--
ALTER TABLE `internalauditactivities`
  MODIFY `lactid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `internalauditsubjects`
--
ALTER TABLE `internalauditsubjects`
  MODIFY `sdid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `itemcategory`
--
ALTER TABLE `itemcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ivitems`
--
ALTER TABLE `ivitems`
  MODIFY `poitid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ivmiscellaneous`
--
ALTER TABLE `ivmiscellaneous`
  MODIFY `poitid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jettyequipments`
--
ALTER TABLE `jettyequipments`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jettyreport`
--
ALTER TABLE `jettyreport`
  MODIFY `jid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jha`
--
ALTER TABLE `jha`
  MODIFY `jhaid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobposition`
--
ALTER TABLE `jobposition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `chid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobtitle`
--
ALTER TABLE `jobtitle`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `legalactivities`
--
ALTER TABLE `legalactivities`
  MODIFY `lactid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `legalmeetings`
--
ALTER TABLE `legalmeetings`
  MODIFY `sdid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `legalsubjects`
--
ALTER TABLE `legalsubjects`
  MODIFY `sdid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lineitems`
--
ALTER TABLE `lineitems`
  MODIFY `LitID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `logistics`
--
ALTER TABLE `logistics`
  MODIFY `logID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `maintain_activities`
--
ALTER TABLE `maintain_activities`
  MODIFY `maid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mljobs`
--
ALTER TABLE `mljobs`
  MODIFY `JOBid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `msg`
--
ALTER TABLE `msg`
  MODIFY `msgid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `noncon`
--
ALTER TABLE `noncon`
  MODIFY `nid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `noteID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `npo`
--
ALTER TABLE `npo`
  MODIFY `RFQid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `opt_cal_method`
--
ALTER TABLE `opt_cal_method`
  MODIFY `calid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `opt_earning_freq`
--
ALTER TABLE `opt_earning_freq`
  MODIFY `enfreqid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `opt_employee_group`
--
ALTER TABLE `opt_employee_group`
  MODIFY `empgid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `otherreceiver`
--
ALTER TABLE `otherreceiver`
  MODIFY `uid` int(9) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payrollelement`
--
ALTER TABLE `payrollelement`
  MODIFY `payid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payrollsettings`
--
ALTER TABLE `payrollsettings`
  MODIFY `pyid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pecheques`
--
ALTER TABLE `pecheques`
  MODIFY `pechq` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `po`
--
ALTER TABLE `po`
  MODIFY `poID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `poinfo`
--
ALTER TABLE `poinfo`
  MODIFY `POinfoID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `poinfocomm`
--
ALTER TABLE `poinfocomm`
  MODIFY `POinfocommID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `poinfolineitem`
--
ALTER TABLE `poinfolineitem`
  MODIFY `POinfoID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `poitems`
--
ALTER TABLE `poitems`
  MODIFY `poitid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pomiscellaneous`
--
ALTER TABLE `pomiscellaneous`
  MODIFY `poitid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `poreq`
--
ALTER TABLE `poreq`
  MODIFY `reqid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `postings`
--
ALTER TABLE `postings`
  MODIFY `tncid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `postingsnew`
--
ALTER TABLE `postingsnew`
  MODIFY `tncid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posting_update`
--
ALTER TABLE `posting_update`
  MODIFY `puid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ppe_kit`
--
ALTER TABLE `ppe_kit`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projdeliverables`
--
ALTER TABLE `projdeliverables`
  MODIFY `LitID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `PROJid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `projecttask`
--
ALTER TABLE `projecttask`
  MODIFY `pID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchaseinvoice`
--
ALTER TABLE `purchaseinvoice`
  MODIFY `siid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchaseinvoicecomm`
--
ALTER TABLE `purchaseinvoicecomm`
  MODIFY `siid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchaseinvoiceitems`
--
ALTER TABLE `purchaseinvoiceitems`
  MODIFY `siid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchaselineitems`
--
ALTER TABLE `purchaselineitems`
  MODIFY `LitID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `purchaseorders`
--
ALTER TABLE `purchaseorders`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recentdeletes`
--
ALTER TABLE `recentdeletes`
  MODIFY `rdid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reciepts`
--
ALTER TABLE `reciepts`
  MODIFY `chid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `regtraining`
--
ALTER TABLE `regtraining`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reqcategory`
--
ALTER TABLE `reqcategory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rfq`
--
ALTER TABLE `rfq`
  MODIFY `RFQid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salesinvoice`
--
ALTER TABLE `salesinvoice`
  MODIFY `siid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salesinvoicecomm`
--
ALTER TABLE `salesinvoicecomm`
  MODIFY `siid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `salesinvoiceitems`
--
ALTER TABLE `salesinvoiceitems`
  MODIFY `siid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setpost`
--
ALTER TABLE `setpost`
  MODIFY `tncid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `setpostgpig`
--
ALTER TABLE `setpostgpig`
  MODIFY `tncid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `so`
--
ALTER TABLE `so`
  MODIFY `poID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `stockhistory`
--
ALTER TABLE `stockhistory`
  MODIFY `shid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `supportingdoc`
--
ALTER TABLE `supportingdoc`
  MODIFY `sdid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `survey`
--
ALTER TABLE `survey`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sysvar`
--
ALTER TABLE `sysvar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `terms`
--
ALTER TABLE `terms`
  MODIFY `termsID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vendorsinvoices`
--
ALTER TABLE `vendorsinvoices`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wh_bins`
--
ALTER TABLE `wh_bins`
  MODIFY `mid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wh_stations`
--
ALTER TABLE `wh_stations`
  MODIFY `cid` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wh_stock`
--
ALTER TABLE `wh_stock`
  MODIFY `sid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `wh_storages`
--
ALTER TABLE `wh_storages`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
