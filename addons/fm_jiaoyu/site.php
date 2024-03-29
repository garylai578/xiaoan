<?php
/**
 * 微教育模块
 * @author 高贵血迹
 * @url http://www.daren007.com
 */
defined ( 'IN_IA' ) or exit ( 'Access Denied' );
require  'inc/func/core.php';
include 'model.php';
define('OSSURL', $_W['sitescheme'].getoauthurl().'/addons/fm_jiaoyu/');
class Fm_jiaoyuModuleSite extends Core {

	// 载入逻辑方法
	private function getLogic($_name, $type = "web", $auth = false) {
		global $_W, $_GPC;
		if ($type == 'web') {
//		    $t1=time();
			checkLogin ();  //检查登陆
//            $t2=time();
			include_once 'inc/func/list.php';
//			$t3=time();
			if($_GPC['schoolid']){
				get_language($_GPC['schoolid']);
				$language = $_W['lanconfig'][$_GPC['do']];
			}
//            $t4 = time();
			include_once 'inc/web/' . strtolower ( substr ( $_name, 5 ) ) . '.php';
//            echo("<br>time,t1:".$t1.", t2-1:".($t2-$t1).", t3-2:".($t3-$t2).", t4-3:".($t4-$t3).", t5-4:".(time()-$t4));
		} else if ($type == 'mobile') {
			 if ($auth) {
				  include_once 'inc/func/isauth.php';
			 }
			get_language($_GPC['schoolid']);
			$language = $_W['lanconfig'][$_GPC['do']];
			include_once 'inc/mobile/' . strtolower ( substr ( $_name, 8 ) ) . '.php';
		} else if ($type == 'func') {
			include_once 'inc/func/' . strtolower ( substr ( $_name, 8 ) ) . '.php';
		}
	}

	//定义mobile common 接入方法
	private function getLogicmc($_name, $type = "web", $auth = false) {
		global $_W, $_GPC;
		mload()->model('read');
		$unread = check_unread($_SESSION['user']);
		if ($type == 'mobile') {
			 if ($auth) {
				  include_once 'inc/func/isauth.php';
			  }
			session_start();
			get_language($_GPC['schoolid']);
			$language = $_W['lanconfig'][$_GPC['do']];
			include_once 'inc/mobile/common/' . strtolower ( substr ( $_name, 8 ) ) . '.php';
			include_once $this->template('loading');	
		}
	}

	private function getLogicms($_name, $type = "web", $auth = false) {
		global $_W, $_GPC;
		mload()->model('read');
		$unread = check_unread($_SESSION['user']);
		if ($type == 'mobile') {
			 if ($auth) {
				  include_once 'inc/func/isauth.php';
			  }
			session_start();
			get_language($_GPC['schoolid']);
			$language = $_W['lanconfig'][$_GPC['do']];
			include_once 'inc/mobile/student/' . strtolower ( substr ( $_name, 8 ) ) . '.php';
			if($_name != 'doMobileSbjq' || $_name != 'doMobileSnoticelist' || $_name != 'doMobileSzjhlist' || !preg_match('/ajax/i', $name) || !preg_match('/list/i', $name) ){
				include_once $this->template('loading');
			}
		}
	}

	private function getLogicmt($_name, $type = "web", $auth = false) {
		global $_W, $_GPC;
		if ($type == 'mobile') {
			if ($auth) {
				include_once 'inc/func/isauth.php';
			}
			get_language($_GPC['schoolid']);
			$language = $_W['lanconfig'][$_GPC['do']];
			include_once 'inc/mobile/teacher/' . strtolower ( substr ( $_name, 8 ) ) . '.php';
			if($_name != 'doMobileBjq' || $_name != 'doMobileNoticelist' || $_name != 'doMobileZuoyelist' || !preg_match('/ajax/i', $name) ){
				include_once $this->template('loading');
			}
		}
	}
	
	private function getLogicheck($_name, $type = "web", $auth = false) {
		global $_W, $_GPC;
		if ($type == 'mobile') {
			include_once 'inc/mobile/' . strtolower ( substr ( $_name, 8 ) ) . '.php';
		}
	}

    public function doWebLoginctrl() {
        include_once 'inc/web/loginctrl.php';
    }	
    public function doWebLanset() {
        include_once 'inc/web/lanset.php';
    }
    public function doWebUpgrade() {
        include_once 'inc/web/upgrade.php';
    }
	
	public function doWebIndexajax() {
		include_once 'inc/web/indexajax.php';
	}
	public function doWebExecl_input() {
		include_once 'inc/web/execl_input.php';
	}
    public function doWebFenzu() {
        include_once 'inc/web/fenzu.php';
    }

    public function doWebArea() {
        include_once 'inc/web/area.php';
    }	
	
    public function doWebType() {
        include_once 'inc/web/type.php';
    }	

    public function doWebManager() {
        include_once 'inc/web/manager.php';
    }

	public function doWebCity() {
		include_once 'inc/web/city.php';
	}

	public function doWebBanners() {
		include_once 'inc/web/banners.php';
	}

    public function doWebQuery() {
        include_once 'inc/web/query.php';
    }
	
    public function doWebBasic() {
        include_once 'inc/web/basic.php';
    }
	
    public function doWebGuid() {
        include_once 'inc/web/guid.php';
    }	
	
	public function doWebComad() {
		include_once 'inc/web/comad.php';
	}
	
	public function doWebSms() {
		include_once 'inc/web/sms.php';
	}

	public function doWebBinding() {
		include_once 'inc/web/binding.php';
	}
	public function doWebSensitive() {
		include_once 'inc/web/sensitive.php';
	}	

	public function doWebComload() {
		include_once 'inc/web/comload.php';
	}	
	
	public function doMobileCheckjl() {
		global $_GPC, $_W;		  
		include_once 'inc/mac/checkjl.php';
	}
	
	public function doMobileCheckxz() {
		global $_GPC, $_W;
		include_once 'inc/mac/checkxz.php';
	}
	
	public function doMobileChecktask() {
		global $_GPC, $_W;
		include_once 'inc/func/task.php';
	}

	public function doMobileCheckym() {
		global $_GPC, $_W;
		include_once 'inc/mac/checkym.php';
	}
	
	public function doMobileCheckabb() {
		global $_GPC, $_W;
		include_once 'inc/mac/checkabb.php';
	}

	public function doMobileCheckhx() {
		global $_GPC, $_W;
		include_once 'inc/mac/checkhx.php';
	}	
	
	public function doMobileCheckwn() {
		global $_GPC, $_W;
		include_once 'inc/mac/checkwn.php';
	}	

	public function doMobileCash() {
		global $_GPC, $_W;
		include_once 'inc/func/cash.php';
	}
	public function doMobileOpenid() {
		global $_GPC, $_W;
		include_once 'inc/func/openid.php';
	}
	

    public function doMobileScplforxs() {
		global $_GPC, $_W;
		include_once 'inc/func/isauth.php';
		include_once 'inc/mobile/student/scplforxs.php';		
	}

    public function doMobileCheckCarPass()
    {
        global $_GPC, $_W;
        include_once 'inc/mac/park/checkCarPass.php';
    }
	// ====================== 讯贞新增 =====================
	public function doWebXz_device() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	public function doWebRemote() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}	
	
 	public function doMobileXz_device() {
		$this->getLogic ( __FUNCTION__, 'mobile' );
	}	
		
	// ====================== Web =====================
    public function doWebHelp() {
        $this->getLogic ( __FUNCTION__, 'web' );
    }
	// 学校管理
	public function doWebSchool() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
    public function doWebQrlist() {
        $this->getLogic ( __FUNCTION__, 'web' );
    }	
	
	public function doWebPoints() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	public function doWebMalladd() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	public function doWebMallorder() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	public function doWebTemplate() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	public function doWebPermiss() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	public function doWebCreates() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}	
	
	// 分类管理
	public function doWebSchoolset() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	// 分类管理
	public function doWebSemester() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	// 教师管理
	public function doWebAssess() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	// 学生管理
	public function doWebStudents() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	// 成绩查询
	public function doWebChengji() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

    // 课程安排
	public function doWebKecheng() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	// 课表安排
	public function doWebKcbiao() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

    // 公立课表
    public function doWebTimetable () {
        $this->getLogic ( __FUNCTION__, 'web' );
    }

	// 课程预约
	public function doWebSubscribe() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	// 食谱安排
	public function doWebCookBook() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	// 首页导航
	public function doWebNave() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	//班级管理
	public function doWebTheclass() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	//成绩管理
	public function doWebScore() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	//科目管理
	public function doWebSubject() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

    //时段管理
	public function doWebTimeframe() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	//星期管理
	public function doWebWeek() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	//教师分组
	public function doWebJsfz() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	//Lee作业写入
	public function doWebWjxr() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
		//Lee作业编辑
	public function doWebZybj() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
    //排课设置
    public function doWebCourseSort () {
        $this->getLogic ( __FUNCTION__, 'web' );
    }

	public function doWebBanner() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

    public function doWebCook() {
        $this->getLogic ( __FUNCTION__, 'web' );
    }
    //forSUTELIST
    public function doWebBaoming() {
        $this->getLogic ( __FUNCTION__, 'web' );
    }

    public function doWebArticle() {
        $this->getLogic ( __FUNCTION__, 'web' );
    }

    public function doWebNews() {
        $this->getLogic ( __FUNCTION__, 'web' );
    }

    public function doWebWenzhang() {
        $this->getLogic ( __FUNCTION__, 'web' );
    }

    public function doWebBjquan() {
        $this->getLogic ( __FUNCTION__, 'web' );
    }

	public function doWebCost() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	public function doWebTestforlee() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	public function doWebPayall() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebPhotos() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebNotice() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebSignup() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	public function doWebCheck() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	public function doWebChecklog() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	public function doWebCardlist() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebstart() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

    public function doWebtown() {
        $this->getLogic ( __FUNCTION__, 'web' );
    }

	public function doWebShoucelist() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	public function doWebShouceset() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	public function doWebAllcamera() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}

	public function doWebGongkaike() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	public function doWebGkkpjxt() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	public function doWebGkkpjtj() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	public function doWebShowgkkpj() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	public function doWebShowpjdetail() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	public function doWebGroupactivity() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	public function doWebGasignup() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	public function doWebHouseorder() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	public function doWebHorecord() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	public function doWebCoursetype() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	public function doWebKcyy() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	public function doWebKcsign() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	public function doWebEditaddr() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
    public function doWebYzxx() {
        $this->getLogic ( __FUNCTION__, 'web' );
    }
    public function doWebKcpingjiashow() {
        $this->getLogic ( __FUNCTION__, 'web' );
    }	
    public function doWebChongzhi() {
        $this->getLogic ( __FUNCTION__, 'web' );
    }
	public function doWebMimax() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	public function doWebSendmsg_muti() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	public function doWebKcallstusign() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	public function doWebCheckdateset() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	public function doWebCheckdatedetail() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	public function doWebChecktimeset() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	public function doWebApartmentset() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	public function doWebAproomset() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	public function doWebApcheck() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	public function doWebBooksborrow() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	public function doWebBooksrecord() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	public function doWebApcheckall() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	public function doWebPrinter() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	public function doWebPrintlog() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	public function doWebTeascore() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	public function doWebTscoreobject() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	public function doWebStudentscore() {
		$this->getLogic ( __FUNCTION__, 'web' );
	}
	
	// ====================== FUNC =====================
	public function doMobileAuth() {
		$this->getLogic ( __FUNCTION__, 'func' );
	}
    // ====================== Mobile=====================
 	// 公共部分	
	public function doMobileQkbinding() { //快速绑定入口
		$this->getLogic ( __FUNCTION__, 'mobile' );
	}
	
	public function doMobileBinding() {
		$this->getLogic ( __FUNCTION__, 'mobile' );
	}	

	public function doMobileComajax() {
		$this->getLogic ( __FUNCTION__, 'mobile' );
	}
	
	public function doMobileIndexajax() {
		$this->getLogic ( __FUNCTION__, 'mobile' );
	}
	
	public function doMobileTecherajax() {
		$this->getLogic ( __FUNCTION__, 'mobile' );
	}	

	public function doMobileBjqajax() {
		$this->getLogic ( __FUNCTION__, 'mobile' );
	}

    public function doMobileXsqjajax() {
        $this->getLogic ( __FUNCTION__, 'mobile');
    }

    public function doMobileDongtaiajax() {
		$this->getLogic ( __FUNCTION__, 'mobile' );
	}

	public function doMobileWapindex() {
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

	public function doMobilePayajax() {
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileBdajax() {
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileBangding() {
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileXsqj() {
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}
	public function doMobilekcajax() {
		$this->getLogic ( __FUNCTION__, 'mobile', true );
	}
	
	

	// ====================== Mobile Common=====================
	public function doMobileGuid() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileShowhomework() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileCooklist() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileCook() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileDetail() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileJianjie() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileKc() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileKcinfo() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileKcdg() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileZhaosheng() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileNewslist() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileNew() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileTeachers() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileTcinfo() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSignup() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSignupjc() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSignuplist() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileGkkpingjia() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileGoodstemp() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileGkkpjshare() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileHorder() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileHodetail() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileNewcoursedetail() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileYystcom() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileYzxx() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}
	
	
	public function doMobileMimax() {
		$this->getLogicmc ( __FUNCTION__, 'mobile', true );
	}
	// ====================== Mobile Student=====================
	public function doMobileSzjhlist() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
  	public function doMobileMyqrcode(){
        $this->getLogicms ( __FUNCTION__, 'mobile', true);
    }
	public function doMobileAssteach() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileChecklogDetail() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}	
	
	public function doMobileSchoolbus() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileWxsign() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}	
	
	public function doMobileCalendar() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}	
	
	public function doMobileSzjh() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileGopay() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileTimetable() {
        $this->getLogicms ( __FUNCTION__, 'mobile', true );
    }

	public function doMobileVideo() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileSxcfb() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileChaxun() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileChengji() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileUser() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	
    public function doMobileMyfamily() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}	
	
    public function doMobileUseredit() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}	

    public function doMobileMyinfo() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileJiaoliu() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMytecher() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMyclass() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSnoticelist() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSnotice() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSzuoye() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSzuoyelist() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSbjqfabu() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSbjq() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileOrder() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMykcinfo() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMykcdetial() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileObinfo() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSxc() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSxclist() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	
    public function doMobileCheckcard() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	
    public function doMobileChecklog() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	
    public function doMobileCallbook() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSlylist() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSduihua() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}	

    public function doMobileScforxs() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSclistforxs() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileLeavelist() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileAllcamera() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileCamera() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileSgoodslist() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileSgoodsdetail() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileSgetorder() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileSeditorder() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileSmallpay() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileSgkkpjjl() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileSignrecord() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileGalist() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileGadetail() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileShrecord() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileSsetaddress() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileSyzxx() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileKcpingjia() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileChongzhi() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	
	
	
	public function doMobileMysharedetail() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileSmyscore() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileYuecostlog() {
		$this->getLogicms ( __FUNCTION__, 'mobile', true );
	}


	// ====================== Mobile Teacher =====================
	//for master
    public function doMobileTallcamera() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
    public function doMobileTcamera() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
    public function doMobileClasschecklog() { //与狼共舞
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobilePaystat() { //与狼共舞
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileMallpay() { //与狼共舞
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	
    public function doMobileStulist() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}	
	
    public function doMobileRehomework() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileGetorder() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileEditorder() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
		
	 public function doMobileGoodslist() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileNopoint() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	 public function doMobileGoodsdetail() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	 public function doMobileSetaddress() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	
	 public function doMobileShangcheng() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}	
	
    public function doMobileQuestionnaire() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	
    public function doMobileQuestatistics() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	
    public function doMobileTcalendar() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	
    public function doMobileWxsignforteacher() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileLeavelistforteacher() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileCheckcardforteacher() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}	
	
    public function doMobileTlylist() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	
    public function doMobileSign() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}	
	
    public function doMobileSignlist() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}	
	
    public function doMobileTduihua() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}	
	
    public function doMobileTmssage() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileTmcomet() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSmssage() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileSmcomet() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMnotice() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMnoticelist() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMfabu() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileQingjia() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileZfabu() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileBjqfabu() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileMyschool() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileBjq() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileZuoye() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileZuoyelist() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileFabu() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileNoticelist() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileNotice() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileTjiaoliulist() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileTjiaoliu() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileXclist() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileXc() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileXcfb() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileBmlist() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileBm() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileTchecklog() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}	
	
    public function doMobileJschecklog() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	
    public function doMobileTongxunlu() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	
    public function doMobileTzjhlist() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileTzjh() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileTzjhadd() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileShoucelist() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileShoucepl() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileShouce() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileShoucepy() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileShouceadd() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileShoucepygl() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

    public function doMobileShoucepyglad() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}	
	
    public function doMobileRecod() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	public function doMobilePointdetail() { 
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	public function doMobilePointrule() { 
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileGkklist() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileGkkdetail() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}	
	public function doMobileGkkadd() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileGkkpjjl() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}	

	//**************2018.2.26(Lee)**************
	public function doMobileCreatetodo() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileTodolist() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

	//**************2018.4.1(Lee)**************
	public function doMobileCyylist() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileCyydetail() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileTmycourse() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileTmykcinfo() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	//学生补签课程
	public function doMobileTxsbqkc() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileTqrjsqd() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileTkcsignall() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileTkcsigndetail() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileTkcsignks() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	public function doMobileTyzxx() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}

	public function doMobileTkcstu() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileTmyscore() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileTscoreall() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileTstuscore() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}
	
	public function doMobileMyinfodetail() {
		$this->getLogicmt ( __FUNCTION__, 'mobile', true );
	}



    public function set_tabbar($action, $schoolid, $role, $isfounder) {
		$logo = pdo_fetch("SELECT is_openht FROM " . tablename($this->table_index) . " WHERE id = '{$schoolid}'");
		$actions_titles = $this->actions_titles;		
		if ($isfounder || $role == 'owner' ){
			$actions_titles = $this->actions_titles11;
		}
		
		if ($role == 'manager' && $logo['is_openht'] == 1){
			$actions_titles = $this->actions_titles22;		
		}
		
        $html = '<ul class="nav nav-tabs">';
        foreach ($actions_titles as $key => $value) {
            $url = $this->createWebUrl($key, array('op' => 'display', 'schoolid' => $schoolid));
            $html .= '<li class="' . ($key == $action ? 'active' : '') . '"><a href="' . $url . '">' . $value . '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }
	
    public $actions_titles = array();
    public $actions_titles22 = array();
    public $actions_titles2 = array( );
    function __construct(){

	    global $_W, $_GPC;
	    
	    $tid = $_W['user']['tid']?$_W['user']['tid']:$_W['role'];
	   //var_dump($_W);
	   if(!empty($tid) && !empty($_GPC['schoolid'])){
		    $schoolid = $_GPC['schoolid'];
			if(IsHasQx($tid,1000211,1,$schoolid)){
				$this->actions_titles['semester'] = NJNAMEGL;
				$this->actions_titles22['semester'] = NJNAMEGL;
			}
			if(IsHasQx($tid,1000221,1,$schoolid)){
				$this->actions_titles['theclass'] = '班级管理';
				$this->actions_titles22['theclass'] = '班级管理';
			}
			if(IsHasQx($tid,1000231,1,$schoolid)){
				$this->actions_titles['score'] = '期号管理';
				$this->actions_titles22['score'] = '期号管理';
			}
			if(IsHasQx($tid,1000241,1,$schoolid)){
				$this->actions_titles['coursetype'] ='课程类型';
				$this->actions_titles22['coursetype'] ='课程类型';
			}
			if(IsHasQx($tid,1000251,1,$schoolid)){
				$this->actions_titles['editaddr'] = '教室管理';
				$this->actions_titles22['editaddr'] = '教室管理';
			}
			if(IsHasQx($tid,1000261,1,$schoolid)){
				$this->actions_titles['subject'] = '科目管理';
				$this->actions_titles22['subject'] = '科目管理';
			}
			if(IsHasQx($tid,1000271,1,$schoolid)){
				$this->actions_titles['timeframe'] = '时段管理';
				$this->actions_titles22['timeframe'] = '时段管理';
			}
			if(IsHasQx($tid,1000281,1,$schoolid)){
				$this->actions_titles['week'] = '星期管理';
				$this->actions_titles22['week'] = '星期管理';
			}
			if(IsHasQx($tid,1000291,1,$schoolid)){
				$this->actions_titles['tscoreobject'] = '评分项目';
				$this->actions_titles22['tscoreobject'] = '评分项目';
			}	
			$this->actions_titles22['jsfz'] = '教师分组';
			$this->actions_titles22['permiss'] = '帐号管理';
			
			if(IsHasQx($tid,1001401,1,$schoolid)){
				$this->actions_titles2['article'] = '校园公告';
			}
			if(IsHasQx($tid,1001411,1,$schoolid)){
				$this->actions_titles2['news'] = '校园新闻';
			} 
			if(IsHasQx($tid,1001421,1,$schoolid)){
				$this->actions_titles2['wenzhang'] = '精选文章';
			}
	 	}
	}
	
    public $actions_titles11 = array(
	    'semester'   => NJNAMEGL,
	    'theclass'   => '班级管理',
	    'score'      => '期号管理',
	    'coursetype' => '课程类型',
	    'editaddr'   => '教室管理',
	    'subject'    => '科目管理',
	    'timeframe'  => '时段管理',
	    'week'       => '星期管理',
		'tscoreobject'=> '评分项目',
	    'jsfz'       => '教师分组',
	    'permiss'    => '帐号管理',
	    'template'   => '模板管理',
    );
	
	
    public function set_tabbar2($action, $schoolid) {
	    
        $actions_titles2 = $this->actions_titles2;
        $html = '<ul class="nav nav-tabs">';
        foreach ($actions_titles2 as $key => $value) {
            $url = $this->createWebUrl($key, array('op' => 'display', 'schoolid' => $schoolid));
            $html .= '<li class="' . ($key == $action ? 'active' : '') . '"><a href="' . $url . '">' . $value . '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }

    

    public function showMessageAjax($msg, $code = 0){
        $result['code'] = $code;
        $result['msg'] = $msg;
        message($result, '', 'ajax');
    }

    protected function exportexcel($data = array(), $title = array(), $filename = 'report') {
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=" . $filename . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
		
        //导出xls 开始
        if (!empty($title)) {
            foreach ($title as $k => $v) {
                $title[$k] = iconv("UTF-8", "GBK", $v);
            }
            $title = implode("\t", $title);
            echo "$title\n";
        }
        if (!empty($data)) {
            foreach ($data as $key => $val) {
                foreach ($val as $ck => $cv) {
                    $data[$key][$ck] = iconv("UTF-8", "GBK", $cv);
                }
                $data[$key] = implode("\t", $data[$key]);

            }
            echo implode("\n", $data);
        }
    }

    function uploadFile($file, $filetempname, $array) {
        //自己设置的上传文件存放路径
        $filePath = '../addons/fm_jiaoyu/public/upload/';

        include 'inc/func/phpexcelreader/reader.php';

        $data = new Spreadsheet_Excel_Reader();
        $data->setOutputEncoding('utf-8');

        //设置时区
        $time = date("y-m-d-H-i-s"); //去当前上传的时间
        $extend = strrchr($file, '.');
        //上传后的文件名
        $name = $time . $extend;
        $uploadfile = $filePath . $name; //上传后的文件名地址

        if (copy($filetempname, $uploadfile)) {
            if (!file_exists($filePath)) {
                echo '文件路径不存在.';
                return;
            }
            if (!is_readable($uploadfile)) {
                echo ("文件为只读,请修改文件相关权限.");
                return;
            }
            $data->read($uploadfile);
            error_reporting(E_ALL ^ E_NOTICE);
            $count = 0;
            for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) { //$=2 第二行开始
                //以下注释的for循环打印excel表数据
                for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {
                    //echo "\"".$data->sheets[0]['cells'][$i][$j]."\",";
                }

                $row = $data->sheets[0]['cells'][$i];
                //message($data->sheets[0]['cells'][$i][1]);

                if ($array['ac'] == "assess") {
                    $count = $count + $this->upload_assess($row, TIMESTAMP, $array);
                } else if ($array['ac'] == "students") {
                    $count = $count + $this->upload_students($row, TIMESTAMP, $array);
                } else if ($array['ac'] == "chengji") {
                    $count = $count + $this->upload_chengji($row, TIMESTAMP, $array);
                } else if ($array['ac'] == "kecheng") {
                    $count = $count + $this->upload_kecheng($row, TIMESTAMP, $array);
                } else if ($array['ac'] == "kcbiao") {
                    $count = $count + $this->upload_kcbiao($row, TIMESTAMP, $array);
                } else if ($array['ac'] == "cardlist") {
                    $count = $count + $this->upload_cardlist($row, TIMESTAMP, $array);			
                } else if ($array['ac'] == "uppyk") {
                    $count = $count + $this->upload_uppyk($row, TIMESTAMP, $array);						
                } else if ($array['ac'] == "bjlist") {
                    $count = $count + $this->upload_bjlist($row, TIMESTAMP, $array);
                } else if ($array['ac'] == "cardlistfromschool") {
                    $count = $count + $this->upload_cardlistfromschool($row, TIMESTAMP, $array);					
                } else if ($array['ac'] == "teascore") {
                    $count = $count + $this->upload_teascore($row, TIMESTAMP, $array);
                }
            }
        }
		$msg = 1;
        if ($count == 0) {
            $msg = "表格设置错误请检查(同名学生和手机号是否重复，学号是否为空或者有重复，同名老师和手机号是否相同等)！";
        }		
        return $msg;
    }

    function upload_assess($strs, $time, $array) {
        global $_W;
        $insert = array();
		//绑定码
		$randStr = str_shuffle('123456789');
        $rand = substr($randStr,0,6);		
		$insert['weid'] = $_W['uniacid'];
		$insert['schoolid'] = $array['schoolid'];
        $insert['tname'] = trim($strs[1]);
        $insert['birthdate'] = strtotime(trim($strs[2]));
        $insert['tel'] = trim($strs[3]);
        $insert['mobile'] = trim($strs[4]);
        $insert['email'] = trim($strs[5]);
		$insert['fz_id'] = '';
        $insert['jiontime'] = strtotime(trim($strs[6]));
        $insert['headinfo'] = trim($strs[7]);
        $insert['info'] = trim($strs[8]);
        $insert['sex'] = trim($strs[9]);
		$insert['jinyan'] = trim($strs[10]);
        $insert['status'] = 1;
        $insert['sort'] = '';
		$insert['code'] = empty($strs[11]) ? $rand : trim($strs[11]);
		$insert['is_show'] = 0;
		$insert['openid'] = '';
		$insert['uid'] = 0;
		$insert['thumb'] = '';

        $assess = pdo_fetch("SELECT * FROM " . tablename('wx_school_teachers') . " WHERE tname=:tname AND mobile=:mobile AND weid=:weid And schoolid=:schoolid LIMIT 1", array(':tname' => trim($strs[1]), ':mobile' => trim($strs[4]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		
        if (empty($assess)) {
            return pdo_insert('wx_school_teachers', $insert);
        } else {
            return 0;
        }
    }
	
    function upload_bjlist($strs, $time, $array) {
        global $_W;
        $insert = array();
		//绑定码		
		$insert['weid'] = $_W['uniacid'];
		$insert['schoolid'] = $array['schoolid'];
        $insert['tid'] = trim($strs[1]);
        $insert['bj_id'] = trim($strs[3]);
        $insert['km_id'] = trim($strs[4]);
		$insert['type'] = 1;

        $class = pdo_fetch("SELECT * FROM " . tablename('wx_school_user_class') . " WHERE tid=:tid AND bj_id=:bj_id AND km_id=:km_id AND weid=:weid And schoolid=:schoolid ", array(':tid' => trim($strs[1]), ':bj_id' => trim($strs[3]), ':km_id' => trim($strs[4]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		
        if (empty($assess)) {
            return pdo_insert('wx_school_user_class', $insert);
        } else {
            return 0;
        }
    }	

    function upload_students($strs, $time, $array) {
        global $_W;
        $insert = array();
		//绑定码
		$randStr = str_shuffle('123456789');
        $rand = substr($randStr,0,6);		
		//年级处理
		$xueqi = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid And type=:type", array(':sname' => trim($strs[9]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid'], ':type'=> 'semester'));
		//班级处理
		$banji = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid And type=:type", array(':sname' => trim($strs[10]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid'], ':type'=> 'theclass'));
        $insert['weid'] = $_W['uniacid'];
        $insert['s_name'] = trim($strs[1]);
        $insert['sex'] = trim($strs[2]);
        $insert['birthdate'] = strtotime(trim($strs[3]));
        $insert['mobile'] = trim($strs[4]);
        $insert['homephone'] = trim($strs[5]);
        $insert['seffectivetime'] = strtotime(trim($strs[6]));
        $insert['stheendtime'] = strtotime(trim($strs[7]));
        $insert['area_addr'] = trim($strs[8]);
		$insert['numberid'] = trim($strs[11]);
        $insert['xq_id'] = empty($xueqi) ? 0 : intval($xueqi['sid']);
        $insert['bj_id'] = empty($banji) ? 0 : intval($banji['sid']);
		$insert['schoolid'] = $array['schoolid'];
		$insert['createdate'] = time();
		$insert['jf_statu'] = '';
		$insert['localdate_id'] = '';
		$insert['note'] = '';
		$insert['code'] = empty($strs[12]) ? $rand : trim($strs[12]);
		$insert['s_type'] = empty($strs[13]) ? 0 : intval($strs[13]);
		$insert['amount'] = '';
		$insert['area'] = '';
		$insert['own'] = '';
		$insert['icon'] = '';

        $students = pdo_fetch("SELECT * FROM " . tablename('wx_school_students') . " WHERE numberid=:numberid AND weid=:weid And schoolid=:schoolid LIMIT 1", array(':numberid' => trim($strs[11]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));

        if (empty($students)) {
            return pdo_insert('wx_school_students', $insert);
        } else {
            return 0;
        }
    }

    function upload_chengji($strs, $time, $array) {
        global $_W;
        $insert = array();
		//班级处理
		$banji = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[3]),':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));		
		//名字处理
		$sid = pdo_fetch("SELECT id FROM " . tablename('wx_school_students') . " WHERE s_name=:s_name AND weid=:weid And schoolid=:schoolid And bj_id = :bj_id ", array(':s_name' => trim($strs[1]),  ':bj_id' => $banji['sid'], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//年级处理
		$xueqi = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[2]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//科目处理
		$kemu = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[4]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
        $insert['sid'] = empty($sid) ? 0 : intval($sid['id']);
        $insert['xq_id'] = empty($xueqi) ? 0 : intval($xueqi['sid']);
		$insert['qh_id'] = $array['qh_id'];
        $insert['bj_id'] = empty($banji) ? 0 : intval($banji['sid']);
        $insert['km_id'] = empty($kemu) ? 0 : intval($kemu['sid']);
        $insert['my_score'] = trim($strs[5]);
		$insert['info'] = trim($strs[6]);
		$insert['schoolid'] = $array['schoolid'];
        $insert['weid'] = $_W['uniacid'];
		$insert['createtime'] = time();

        return pdo_insert('wx_school_score', $insert);
    }
	
	
	 function upload_teascore($strs, $time, $array) {
        global $_W;
        $insert = array();		

		$tid = pdo_fetch("SELECT id FROM " . tablename('wx_school_teachers') . " WHERE tname=:tname AND weid=:weid And schoolid=:schoolid  ", array(':tname' => trim($strs[1]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));

        $insert['tid'] = empty($tid) ? 0 : intval($tid['id']);
		$insert['score'] = trim($strs[2]);
		$insert['obid'] = $array['ob_id'];
		$parentobid = pdo_fetch("SELECT parentid FROM " . tablename('wx_school_classify') . " WHERE sid='{$array['ob_id']}' AND weid='{$_W['uniacid']}' And schoolid='{$array['schoolid']}' and type='tscoreobject'")['parentid'];
		$insert['parentobid'] = $parentobid;
		$insert['fromtid'] = $array['fromtid'];
		if($array['fromtid'] == 'founder' || $array['fromtid'] == 'owner' ){
			$insert['fromfzid'] = -1 ;
		}else{
			$fromtea = pdo_fetch("SELECT fz_id FROM " . tablename('wx_school_teachers') . " WHERE tid=:tid AND weid=:weid And schoolid=:schoolid  ", array(':tid' => $array['fromtid'], ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
			$insert['fromfzid'] = $fromtea['fz_id'];
		}
		$insert['scoretime'] = strtotime($strs[3]);
		$insert['schoolid'] = $array['schoolid'];
        $insert['weid'] = $_W['uniacid'];
		$insert['createtime'] = time();
		$check = pdo_fetch("SELECT id FROM " . tablename('wx_school_teascore') . " WHERE tid='{$tid['id']}' AND weid='{$_W['uniacid']}' And schoolid='{$array['schoolid']}' and obid = '{$array['ob_id']}' and scoretime = '{$insert['scoretime']}'  ");
		if(!empty($check)){
			return pdo_update('wx_school_teascore', $insert,array('id'=>$check['id']));
		}else{
			return pdo_insert('wx_school_teascore', $insert);
		}
        
    }

    function upload_kecheng($strs, $time, $array) {
        global $_W;
        $insert = array();
		//名字处理
		$tid = pdo_fetch("SELECT id FROM " . tablename('wx_school_teachers') . " WHERE tname=:tname AND weid=:weid And schoolid=:schoolid ", array(':tname' => trim($strs[1]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//年级处理
		$xueqi = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[2]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//班级处理
		$banji = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[4]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//科目处理
		$kemu = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[5]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
        $insert['tid'] = empty($tid) ? 0 : intval($tid['id']);
        $insert['xq_id'] = empty($xueqi) ? 0 : intval($xueqi['sid']);
		$insert['name'] = trim($strs[3]);
        $insert['bj_id'] = empty($banji) ? 0 : intval($banji['sid']);
        $insert['km_id'] = empty($kemu) ? 0 : intval($kemu['sid']);
        $insert['minge'] = trim($strs[6]);
		$insert['yibao'] = trim($strs[7]);
		$insert['cose'] = trim($strs[8]);
		$insert['dagang'] = trim($strs[9]);
		$insert['adrr'] = trim($strs[10]);
		$insert['is_hot'] = trim($strs[11]);
		$insert['ssort'] = trim($strs[14]);
		$insert['is_show'] = 1;
		$insert['start'] = strtotime(trim($strs[12]));
		$insert['end'] = strtotime(trim($strs[13]));
		$insert['schoolid'] = $array['schoolid'];
        $insert['weid'] = $_W['uniacid'];

        return pdo_insert('wx_school_tcourse', $insert);
    }

    function upload_kcbiao($strs, $time, $array) {
        global $_W;
        $insert = array();
		//获取课程名字
		$kc = pdo_fetch("SELECT id FROM " . tablename('wx_school_tcourse') . " WHERE id=:id AND weid=:weid And schoolid=:schoolid ", array(':id' => trim($strs[1]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//获取课程对应班级
        $bj = pdo_fetch("SELECT bj_id FROM " . tablename('wx_school_tcourse') . " WHERE id=:id AND weid=:weid And schoolid=:schoolid ", array(':id' => trim($strs[1]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
        //获取课程对应科目
        $km = pdo_fetch("SELECT km_id FROM " . tablename('wx_school_tcourse') . " WHERE id=:id AND weid=:weid And schoolid=:schoolid ", array(':id' => trim($strs[1]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
        //获取教师ID
		$tid = pdo_fetch("SELECT id FROM " . tablename('wx_school_teachers') . " WHERE tname=:tname AND weid=:weid And schoolid=:schoolid ", array(':tname' => trim($strs[2]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//获取星期
		$xq = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[3]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		//获取时段
		$shiduan = pdo_fetch("SELECT sid,sd_start FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[4]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));
		
		//获取教室ID
		$addr = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid ", array(':sname' => trim($strs[5]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));

        $insert['kcid'] = empty($kc) ? 0 : intval($kc['id']);
	    $insert['tid'] = empty($tid) ? 0 : intval($tid['id']);
        $insert['xq_id'] = empty($xq) ? 0 : intval($xq['sid']);
		$insert['sd_id'] = empty($shiduan) ? 0 : intval($shiduan['sid']);
        $insert['bj_id'] = empty($bj) ? 0 : intval($bj['bj_id']);
        $insert['km_id'] = empty($km) ? 0 : intval($km['km_id']);
     	$insert['addr_id'] = empty($addr) ? 0 : intval($addr['sid']);
        $insert['nub'] = trim($strs[6]);
        $lasttime =trim($strs[7]).date(" H:i",$shiduan['sd_start']);
		$insert['date'] = strtotime($lasttime);
		$insert['schoolid'] = $array['schoolid'];
        $insert['weid'] = $_W['uniacid'];

        return pdo_insert('wx_school_kcbiao', $insert);
    }


    
	
    function upload_cardlistfromschool($strs, $time, $array) {
        global $_W;
        $insert = array();
		if(substr($strs[1], 0, 1) == "s"){
		    $strs1 = ltrim($strs[1],"s");
		}else{
			$strs1 = $strs[1];
		}
		$card = pdo_fetch("SELECT id FROM " . tablename('wx_school_idcard') . " WHERE idcard=:idcard AND weid=:weid And schoolid=:schoolid And sid=:sid And tid=:tid", array(':idcard' => trim($strs1), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid'], ':sid'=> 0, ':tid'=> 0));	
		if (!empty($strs[3])){
		$tid = pdo_fetch("SELECT id,tname,thumb FROM " . tablename('wx_school_teachers') . " WHERE tname=:tname AND weid=:weid And schoolid=:schoolid ", array(':tname' => trim($strs[3]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));			
		}
		if (!empty($strs[4])){
		//班级处理
		$banji = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid And type=:type ", array(':sname' => trim($strs[4]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid'], ':type'=> 'theclass'));
		}
		//名字处理
		if (!empty($strs[1])){
		$sid = pdo_fetch("SELECT id FROM " . tablename('wx_school_students') . " WHERE s_name=:s_name AND weid=:weid And schoolid=:schoolid And bj_id=:bj_id ", array(':s_name' => trim($strs[2]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid'], ':bj_id'=> $banji['sid']));
		}
        $insert['weid'] = $_W['uniacid']; 
		$insert['schoolid'] = $array['schoolid'];
		$insert['idcard'] = trim($strs1);
		$insert['sid'] = empty($sid) ? 0 : intval($sid['id']);
		$insert['tid'] = empty($tid) ? 0 : intval($tid['id']);
		$insert['bj_id'] = empty($banji) ? 0 : intval($banji['sid']);
		$insert['createtime'] = empty($strs[7]) ? 0 : time();
        $insert['severend'] = strtotime(trim($strs[5]));
		$insert['spic'] = "";
		$insert['tpic'] = "";
		$insert['is_on'] = empty($strs[7]) ? 0 : 1;
		$insert['usertype'] = empty($strs[3]) ? 0 : 1;
		$insert['pard'] = empty($strs[6]) ? 0 : intval($strs[6]);
		$insert['pname'] = empty($strs[7]) ? 0 : trim($strs[7]);
        
		if (!empty($card)) {
            return pdo_update('wx_school_idcard', $insert, array('idcard' => $strs1));
        }else{
			 message('操作成功,【'.$strs1.'】无法导入');
		}
    }	
	
    function upload_cardlist($strs, $time, $array) {
        global $_W;
        $insert = array();
		$card = pdo_fetch("SELECT id FROM " . tablename('wx_school_idcard') . " WHERE idcard=:idcard AND weid=:weid And schoolid=:schoolid ", array(':idcard' => trim($strs[1]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));	
		if (!empty($strs[3])){
		$tid = pdo_fetch("SELECT id,tname,thumb FROM " . tablename('wx_school_teachers') . " WHERE tname=:tname AND weid=:weid And schoolid=:schoolid ", array(':tname' => trim($strs[3]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid']));			
		}
		if (!empty($strs[4])){
		//班级处理
		$banji = pdo_fetch("SELECT sid FROM " . tablename('wx_school_classify') . " WHERE sname=:sname AND weid=:weid And schoolid=:schoolid And type=:type ", array(':sname' => trim($strs[4]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid'], ':type'=> 'theclass'));
		}
		//名字处理
		if (!empty($strs[1])){
		$sid = pdo_fetch("SELECT id FROM " . tablename('wx_school_students') . " WHERE s_name=:s_name AND weid=:weid And schoolid=:schoolid And bj_id=:bj_id ", array(':s_name' => trim($strs[2]), ':weid' => $_W['uniacid'], ':schoolid'=> $array['schoolid'], ':bj_id'=> $banji['sid']));
		}
        $insert['weid'] = $_W['uniacid']; 
		$insert['schoolid'] = $array['schoolid'];
		$insert['idcard'] = trim($strs[1]);
		$insert['sid'] = empty($sid) ? 0 : intval($sid['id']);
		$insert['tid'] = empty($tid) ? 0 : intval($tid['id']);
		$insert['bj_id'] = empty($banji) ? 0 : intval($banji['sid']);
		$insert['createtime'] = empty($strs[7]) ? 0 : time();
        $insert['severend'] = strtotime(trim($strs[5]));
		$insert['spic'] = "";
		$insert['tpic'] = "";
		$insert['is_on'] = empty($strs[7]) ? 0 : 1;
		$insert['usertype'] = empty($strs[3]) ? 0 : 1;
		$insert['pard'] = empty($strs[6]) ? 0 : intval($strs[6]);
		$insert['pname'] = empty($strs[7]) ? 0 : trim($strs[7]);
        
		if (empty($card)) {
          	if($insert['sid'] != 0)
		        pdo_update('wx_school_students', array("createdate"=>time()), array('id'=>$insert['sid']));
            if($insert['tid'] != 0)
                pdo_update('wx_school_teachers', array("updatetime"=>time()), array('id'=>$insert['tid']));

            return pdo_insert('wx_school_idcard', $insert);
        }else{
			 message('有重复卡号【'.$strs[1].'】，请检查');
		}
    }

    function upload_uppyk($strs, $time, $array) {
        global $_W;
        $insert = array();
        $insert['weid'] = $_W['uniacid']; 
		$insert['schoolid'] = $array['schoolid'];
		$insert['ssort'] = trim($strs[1]);
		$insert['title'] = trim($strs[2]);
        $insert['createtime'] = time();
         return pdo_insert('wx_school_shoucepyk', $insert);
    }	

    private function checkUploadFileMIME($file) {
        // 1.through the file extension judgement 03 or 07
        $flag = 0;
        $file_array = explode(".", $file ["name"]);
        $file_extension = strtolower(array_pop($file_array));

        // 2.through the binary content to detect the file
        switch ($file_extension) {
            case "xls" :
                // 2003 excel
                $fh = fopen($file ["tmp_name"], "rb");
                $bin = fread($fh, 8);
                fclose($fh);
                $strinfo = @unpack("C8chars", $bin);
                $typecode = "";
                foreach ($strinfo as $num) {
                    $typecode .= dechex($num);
                }
                if ($typecode == "d0cf11e0a1b11ae1") {
                    $flag = 1;
                }
                break;
            case "xlsx" :
                // 2007 excel
                $fh = fopen($file ["tmp_name"], "rb");
                $bin = fread($fh, 4);
                fclose($fh);
                $strinfo = @unpack("C4chars", $bin);
                $typecode = "";
                foreach ($strinfo as $num) {
                    $typecode .= dechex($num);
                }
                echo $typecode . 'test';
                if ($typecode == "504b34") {
                    $flag = 1;
                }
                break;
        }

        // 3.return the flag
        return $flag;
    }

    public function doWebUploadExcel() {
        global $_GPC, $_W;

        if ($_GPC['leadExcel'] == "true") {
            $filename = $_FILES['inputExcel']['name'];
            $tmp_name = $_FILES['inputExcel']['tmp_name'];

            $flag = $this->checkUploadFileMIME($_FILES['inputExcel']);
            if ($flag == 0) {
                message('文件格式不对.');
            }

            if (empty($tmp_name)) {
                message('请选择要导入的Excel文件！');
            }
            if ($_GPC['ac'] == 'chengji') {
				if (empty($_GPC['qh_id'])) {
					message('请选择成绩期号！');
				}
            }
			if ($_GPC['ac'] == 'teascore') {
				if (empty($_GPC['ob_id'])) {
					message('请选择评分项目！');
				}
            }
            $msg = $this->uploadFile($filename, $tmp_name, $_GPC);

            if ($msg == 1) {
                message('导入成功！', referer(), 'success');
            } else {
                message($msg, '', 'error');
            }
        }
    }
    public function doWebUploadExcels() {
        global $_GPC, $_W;

        if ($_GPC['leadExcels'] == "true") {
            $filename = $_FILES['inputExcels']['name'];
            $tmp_name = $_FILES['inputExcels']['tmp_name'];

            $flag = $this->checkUploadFileMIME($_FILES['inputExcels']);
            if ($flag == 0) {
				print_r($flag);
                message('文件格式不对.');
            }

            if (empty($tmp_name)) {
                message('请选择要导入的Excel文件！');
            }

            $msg = $this->uploadFile($filename, $tmp_name, $_GPC);

            if ($msg == 1) {
                message('导入成功！', referer(), 'success');
            } else {
                message($msg, '', 'error');
            }
        }
    }
	public function weixin_fans_group($url, $data) {
		global $_W, $_GPC;
		$weid = $_W['uniacid'];
		load()->classs('weixin.account');
		$access_token = WeAccount::token();
		$url = sprintf($url, $access_token);
		load()->func('communication');
		$response = ihttp_request($url, $data);
		if (is_error($response)) {
			return error(-1, "访问公众平台接口失败, 错误: {$response['message']}");
		}
		$result = @json_decode($response['content'], true);
		if (empty($result)) {
		} elseif (!empty($result['errcode'])) {
			if($result['errcode'] == 45157){
				message("标签名非法，请注意不能和其他标签重名");
			}
			if($result['errcode'] == 45158){
				message("标签名长度超过30个字节");
			}
			if($result['errcode'] == 45056){
				message("创建的标签数过多，请注意不能超过100个,如有特殊需求，请向微信团队申请");
			}			
			if($result['errcode'] == -1){
				message("微信服务器繁忙，请稍后再试");
			}			
		}
		return $result;
	}

	public function createImageUrlCenter($qr_file,$schoolid) {
		global $_W, $_GPC;
		$param = pdo_fetch("select * from " . tablename($this->table_qrset) . " where id = :id", array(':id' => 1));
		$school = pdo_fetch("select logo,title from " . tablename($this->table_index) . " where id = :id ", array(':id' => $schoolid));
		load()->func('file');
		mkdirs('../attachment/images/');
		$target_file = "../attachment/images/". time() . random(16) . ".jpg";

		if (!empty($school['logo'])) {
			$src_file = tomedia($school['logo']);
		} else {
			message('抱歉，'.$school['title'].'没有设置LOGO,请先到学校管理编辑上传学校的LOGO');
		}
		$this->resizeImage($this->imagecreate($qr_file), intval($param['logoqrwidth']), intval($param['logoqrheight']), $target_file);
		list($qrWidth, $qrHeight) = getimagesize($target_file);
		$centerleft = ($qrWidth - intval($param['logowidth'])) / 2;
		$centertop = ($qrHeight - intval($param['logoheight'])) / 2;
		$this->mergeImage($target_file, $src_file, $target_file, array('left' => $centerleft, 'top' => $centertop, 'width' => $param['logowidth'], 'height' => $param['logoheight']));
		return $target_file;
	}
	
	public function createImageUrlCenterForUser($qr_file,$sid,$tid,$schoolid) {
		global $_W, $_GPC;
		$param = pdo_fetch("select * from " . tablename($this->table_qrset) . " where id = :id", array(':id' => 1));
		if($tid == 0){
			$student = pdo_fetch("select icon from " . tablename($this->table_students) . " where id = :id ", array(':id' => $sid));
			if(!$student['icon']){
				$school = pdo_fetch("select spic,logo from " . tablename($this->table_index) . " where id = :id ", array(':id' => $schoolid));
				$src_file = tomedia($school['spic']);
				if($sid == 9999999999){
					$src_file = tomedia($school['logo']);
				}				
			}else{
				$src_file = tomedia($student['icon']);
			}
		}
		if($sid == 0){
			$techer = pdo_fetch("select thumb from " . tablename($this->table_teachers) . " where id = :id ", array(':id' => $tid));
			if(!$techer['thumb']){
				$school = pdo_fetch("select tpic from " . tablename($this->table_index) . " where id = :id ", array(':id' => $schoolid));
				$src_file = tomedia($school['tpic']);
			}else{
				$src_file = tomedia($techer['thumb']);
			}
		}		
		load()->func('file');
		mkdirs('../attachment/images/fm_jiaoyu/');
		$target_file = "../attachment/images/fm_jiaoyu/". time() . random(16) . ".jpg";
		$this->resizeImage($this->imagecreate($qr_file), intval($param['logoqrwidth']), intval($param['logoqrheight']), $target_file);
		list($qrWidth, $qrHeight) = getimagesize($target_file);
		$centerleft = ($qrWidth - intval($param['logowidth'])) / 2;
		$centertop = ($qrHeight - intval($param['logoheight'])) / 2;
		$this->mergeImage($target_file, $src_file, $target_file, array('left' => $centerleft, 'top' => $centertop, 'width' => $param['logowidth'], 'height' => $param['logoheight']));
		return $target_file;
	}	

	private function mergeImage($bg, $qr, $out, $param) {

		global $_W, $_GPC;
		load()->func('file');
		list($bgWidth, $bgHeight) = getimagesize($bg);
		list($qrWidth, $qrHeight) = getimagesize($qr);
		$bgImg = $this->imagecreate($bg);
		$qrImg = $this->imagecreate($qr);
		imagecopyresized($bgImg, $qrImg, $param['left'], $param['top'], 0, 0, $param['width'], $param['height'], $qrWidth, $qrHeight);
		ob_start();
		imagejpeg($bgImg, NULL, 100);
		$contents = ob_get_contents();
		ob_end_clean();
		imagedestroy($bgImg);
		imagedestroy($qrImg);

		file_write($out, $contents);

		//$fh = fopen($out, "w+");
		//fwrite($fh, $contents);
		//fclose($fh);
	}

	function resizeImage($im, $maxwidth, $maxheight, $path)	{
		$pic_width = imagesx($im);
		$pic_height = imagesy($im);
		if (($maxwidth && $pic_width > $maxwidth) || ($maxheight && $pic_height > $maxheight)) {
			if ($maxwidth && $pic_width > $maxwidth) {
				$widthratio = $maxwidth / $pic_width;
				$resizewidth_tag = true;
			}
			if ($maxheight && $pic_height > $maxheight) {
				$heightratio = $maxheight / $pic_height;
				$resizeheight_tag = true;
			}
			if ($resizewidth_tag && $resizeheight_tag) {
				if ($widthratio < $heightratio) $ratio = $widthratio; else $ratio = $heightratio;
			}
			if ($resizewidth_tag && !$resizeheight_tag) $ratio = $widthratio;
			if ($resizeheight_tag && !$resizewidth_tag) $ratio = $heightratio;
			$newwidth = $pic_width * $ratio;
			$newheight = $pic_height * $ratio;
			if (function_exists('imagecopyresampled')) {
				$newim = imagecreatetruecolor($newwidth, $newheight);
				imagecopyresampled($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height);
			} else {
				$newim = imagecreate($newwidth, $newheight);
				imagecopyresized($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $pic_width, $pic_height);
			}
			imagejpeg($newim, $path);
			imagedestroy($newim);
		} else {
			imagejpeg($im, $path);
		}
	}

	private function imagecreate($bg) {
		$bgImg = @imagecreatefromjpeg($bg);
		if (FALSE == $bgImg) {
			$bgImg = @imagecreatefrompng($bg);
		}
		if (FALSE == $bgImg) {
			$bgImg = @imagecreatefromgif($bg);
		}
		return $bgImg;
	}
	
	public function doMobilePay() {
		global $_W, $_GPC;
        checkauth();
		$schoolid = intval($_GPC['schoolid']);
		$openid = $_W['openid'];
		$cose = $_GPC ['cose'];
		$wxpayid = intval($_GPC ['wxpay']);
        //构造支付请求中的参数
        $params = array(
            'tid' => $wxpayid,      //充值模块中的订单号，此号码用于业务模块中区分订单，交易的识别码
            'ordersn' => time(),  //收银台中显示的订单号
            'title' => '在线缴费',          //收银台中显示的标题
            'fee' => $cose,
            //'user' => $_W['member']['uid'],     //付款用户, 付款的用户名(选填项)
        );
        //调用pay方法
        include $this->template('students/pay');
	}
    /**
     * 支付后触发这个方法
     * @param $params
     */
	public function payResult($params) {
		global $_W, $_GPC;
		$orderid = $params['tid'];
        $wxpay = pdo_fetch("SELECT * FROM " . tablename($this->table_wxpay) . " WHERE id = '{$orderid}'");
		$lala = 'ss';
		if ($params['result'] == 'success' && $params['from'] == 'notify') {
			$lala .= 'sadas';
			$log = pdo_fetch("SELECT tag FROM " . tablename('core_paylog') . " where tid = :tid ", array(':tid' => $orderid));
			$tag = iunserializer($log['tag']);
			$uniontid = $tag['transaction_id'];
			pdo_update($this->table_wxpay, array('status' => 2), array('id' => $orderid));
			pdo_update($this->table_order, array('status' => 2, 'uniontid' => $uniontid, 'paytime' => time(), 'paytype' => 1, 'pay_type' => $params['type']), array('id' => $wxpay['od1']));
			$order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where id = :id ", array(':id' => $wxpay['od1']));
			$cose = $order['cose'];
			if ($params['fee'] != $cose) {
				exit('支付失败');
			}
			//商城订单
			if(!empty($order['morderid']) && $order['type'] == 6 ){
				$mallinfo = pdo_fetch("SELECT mallsetinfo FROM " . tablename($this->table_index) . " WHERE :schoolid = id AND weid=:weid ", array(':schoolid' => $order['schoolid'],':weid'=>$order['weid'] ));
				$mallinfoDE = iunserializer($mallinfo['mallsetinfo']);
				$auto = $mallinfoDE['isAuto'];
				if($auto == 1  ){
					pdo_update($this->table_mallorder, array('status' => 3), array('id' => $order['morderid']));
				}else{
					pdo_update($this->table_mallorder, array('status' => 2), array('id' => $order['morderid']));
				}
				$teaid = pdo_fetch("SELECT * FROM " . tablename($this->table_mallorder) . " where id = :id ", array(':id' => $order['morderid']));
				//教师订单
				if(!empty($teaid['tid']) && empty($teaid['sid'])){
					$teacher = pdo_fetch("SELECT point FROM " . tablename($this->table_teachers) . " where id = :id ", array(':id' => $teaid['tid']));
					if($teacher['point'] == $teaid['allpoint']){
						$new_point = 0 ;
					}else{
						$new_point = intval($teacher['point']) - intval($teaid['allpoint']);
					}
					pdo_update($this->table_teachers, array('point' => $new_point ), array('id' => $teaid['tid']));
				//学生订单
				}elseif(empty($teaid['tid'] ) && !empty($teaid['sid'])){
					$JFinfo =  pdo_fetch("SELECT Is_point,Cost2Point FROM " . tablename($this->table_index) . " WHERE :schoolid = id AND weid=:weid ", array(':schoolid' => $order['schoolid'],':weid'=>$order['weid'] ));
					if($JFinfo['Is_point'] ==1){
						$students = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where id = :id ", array(':id' => $teaid['sid']));
						$money = $order['cose'];
						$Cost2Point = $JFinfo['Cost2Point'];
						$addpoint = intval($money * $Cost2Point);
						if($students['points'] == $teaid['allpoint']){
							$new_point = 0 + $addpoint;
						}else{
							$new_point = intval($students['points']) - intval($teaid['allpoint']) + $addpoint;
						}
						pdo_update($this->table_students, array('points' => $new_point ), array('id' => $teaid['sid']));
					}
				}
			}
			
			//课程订单
			if($order['type'] == 1){
				//新增学生
				$shareset_t = pdo_fetch("SELECT shareset FROM " . tablename($this->table_index) . " WHERE :schoolid = id AND weid=:weid ", array(':schoolid' => $order['schoolid'],':weid'=>$order['weid'] ));
				$shareset = unserialize($shareset_t['shareset']);
				if($order['tempsid'] != 0){
					$tempstu = pdo_fetch("SELECT * FROM " . tablename($this->table_tempstudent) . " where :id = id", array(':id' => $order['tempsid']));
					$randStr = str_shuffle('123456789');
       				$rand = substr($randStr,0,6);	
       				$nj_id = pdo_fetch("SELECT parentid FROM " . tablename($this->table_classify) . " where :id = id", array(':id' => $tempstu['bj_id']));
					$tempstudata = array(
						'schoolid' => $tempstu['schoolid'],
						'bj_id'=> $tempstu['bj_id'],
						'xq_id' => $nj_id['parentid'],
						'sex' => $tempstu['sex'],
						'createdate'=> time(),
						'seffectivetime' => time(),
						'code' => $rand,
						's_name' => $tempstu['sname'],
						'mobile'=> $tempstu['mobile'],
						'area_addr'=> $tempstu['adde'],
						'weid' => $tempstu['weid'],
					);
					pdo_insert($this->table_students,$tempstudata);
					$sid = pdo_insertid();
					pdo_update($this->table_students,array('keyid'=> $sid),array('id'=>$sid));
					$tempuinfo = array(
						'name' => '',
						'mobile'=> $tempstu['mobile']
					);
					$uinfo = serialize($tempuinfo);
					$userinsert = array(
						'sid' => $sid,
						'weid' => $tempstu['weid'],
						'schoolid' => $tempstu['schoolid'],
						'uid' => $tempstu['uid'],
						'openid' => $tempstu['openid'],
						'pard' => $tempstu['pard'],
						'userinfo' => $uinfo
					);
					pdo_insert($this->table_user,$userinsert);
					$userid_tostu = pdo_insertid();
					$into_stu = array();
					if($tempstu['pard'] == 2){
						$into_stu['mom'] = $tempstu['openid'];
						$into_stu['muserid'] = $userid_tostu;
						$into_stu['muid'] = $tempstu['uid']; 
					}
					if($tempstu['pard'] == 3){
						$into_stu['dad'] = $tempstu['openid'];
						$into_stu['duserid'] = $userid_tostu;
						$into_stu['duid'] = $tempstu['uid']; 
					}
					if($tempstu['pard'] == 4){
						$into_stu['own'] = $tempstu['openid'];
						$into_stu['ouserid'] = $userid_tostu;
						$into_stu['ouid'] = $tempstu['uid']; 
					}
					if($tempstu['pard'] == 5){
						$into_stu['other'] = $tempstu['openid'];
						$into_stu['otheruserid'] = $userid_tostu;
						$into_stu['otheruid'] = $tempstu['uid']; 
					}
					pdo_update($this->table_students,$into_stu,array('id'=>$sid));
					
					$into_order = array(
						'userid' => $userid_tostu,
						'sid' => $sid
					);
					pdo_update($this->table_order,$into_order,array('id'=>$order['id']));
					$order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where id = :id ", array(':id' =>$order['id']));
				}
				//课时购买/续购
				if(!empty($order['ksnum'])){
					$kcinfo =  pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " where :id = id", array(':id' => $order['kcid']));
					$userinfo = pdo_fetch("SELECT sid FROM " . tablename($this->table_user) . " where :id = id", array(':id' => $order['userid']));
					$ygks = pdo_fetch("SELECT ksnum,id FROM " . tablename($this->table_coursebuy) . " where kcid=:kcid AND :sid = sid", array(':kcid' => $order['kcid'],':sid'=>$userinfo['sid']));
					if(!empty($ygks)){
						$newksnum = $ygks['ksnum'] + $order['ksnum'];
						$data_coursebuy = array(
							'ksnum'      => $newksnum,
						);
						pdo_update($this->table_coursebuy,$data_coursebuy,array('id' => $ygks['id']));
					}else{
						$userinfo = pdo_fetch("SELECT sid FROM " . tablename($this->table_user) . " where :id = id", array(':id' => $order['userid']));
						$data_coursebuy = array(
							'weid'       => $order['weid'],
							'schoolid'   => $order['schoolid'],
							'userid'     => $order['userid'],
							'sid'        => $userinfo['sid'],
							'kcid'       => $order['kcid'],
							'ksnum'      => $kcinfo['FirstNum'],
							'createtime' => time()
						);
						pdo_insert($this->table_coursebuy,$data_coursebuy);
					}
				}
				$JFinfo=  pdo_fetch("SELECT Is_point,Cost2Point FROM " . tablename($this->table_index) . " WHERE :schoolid = id AND weid=:weid ", array(':schoolid' => $order['schoolid'],':weid'=>$order['weid'] ));
				$student = pdo_fetch("SELECT points FROM " . tablename($this->table_students) . " where :id = id", array(':id' => $order['sid']));
				if($JFinfo['Is_point'] ==1){
					$money = $order['cose'];
					$Cost2Point = $JFinfo['Cost2Point'];
					$addpoint = $money * $Cost2Point;
					$costpoint = $order['spoint'];
					$oldpoint=$student['points'];
					$newpoint = $oldpoint - $costpoint + $addpoint;
					pdo_update($this->table_students, array('points' => $newpoint ), array('id' => $order['sid']));
				}
				//分享增加积分、余额、课程课时
				if($shareset['is_share'] != 0 ){
					
				 	if($order['shareuserid'] != 0){
						$sharesid = pdo_fetch("SELECT sid FROM " . tablename($this->table_user) . " where :id = id", array(':id' => $order['shareuserid']));
				 		$student_share = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " where :id = id", array(':id' => $sharesid['sid']));
						$temp_student = array();
						//给分享源用户新增积分、余额、课时
						if($shareset['is_share'] == 1){
							//新增积分
							$AddJF = $shareset['addJF'];
							$oldJF = $student_share['points'];
							$newJF = $AddJF + $oldJF;
							//$temp_student['points'] = $newJF;
							pdo_update($this->table_students, array('points' => $newJF ), array('id' => $sharesid['sid']));
						}elseif($shareset['is_share'] == 2){
							//新增余额
							$AddYE = $shareset['addYE'];
							$oldYE = $student_share['chongzhi'];
							$newYE = $AddYE + $oldYE;
							//$temp_student['chongzhi'] = $newYE;
							pdo_update($this->table_students, array('chongzhi' => $newYE ), array('id' => $sharesid['sid']));
						}elseif($shareset['is_share'] == 3){
							//新增课时
							$AddKC = $order['kcid'];
							$AddKS = $shareset['addKS'];
							$kcinfo_share =  pdo_fetch("SELECT * FROM " . tablename($this->table_tcourse) . " where :id = id", array(':id' => $AddKC));
							$coursebuy =  pdo_fetch("SELECT ksnum,id FROM " . tablename($this->table_coursebuy) . " where kcid=:kcid AND :sid = sid", array(':kcid' => $AddKC,':sid'=>$sharesid['sid']));
							if(!empty($coursebuy)){
								$newksnum = $coursebuy['ksnum'] + $AddKS;
								if($newksnum > $kcinfo_share['AllNum']){
									$newksnum = $kcinfo_share['AllNum'];
								}
								pdo_update($this->table_coursebuy, array('ksnum' => $newksnum ), array('id' => $coursebuy['id']));
							}
						} 
					} 
					
				} 
				
				$this->sendMobileJfjgtz($order['id']);
			}else if($order['type'] == 5){
				$school = pdo_fetch("SELECT cardset FROM " . tablename($this->table_index) . " WHERE id = :id ", array(':id' => $wxpay['schoolid']));
				$chard = pdo_fetch("SELECT severend FROM " . tablename($this->table_idcard) . " WHERE id = :id ", array(':id' => $order['bdcardid']));
				$card = unserialize($school['cardset']);
					if($card['cardtime'] == 1){
						$severend = $card['endtime1'] * 86400 + $chard['severend'];
					}else{
						$severend = $card['endtime2'];
					}				
				pdo_update($this->table_idcard, array('severend' => $severend), array('id' => $order['bdcardid']));
				$this->sendMobileJfjgtz($order['id']);
			//充值订单
			}elseif($order['type'] == 8){
				$sid = $order['sid'];
				$students = pdo_fetch("SELECT chongzhi FROM " . tablename($this->table_students) . " where :id = id", array(':id' =>$sid));
				$taocan = pdo_fetch("SELECT chongzhi FROM " . tablename($this->table_chongzhi) . " where :id = id", array(':id' =>$order['taocanid']));
				$new = $students['chongzhi'] + $taocan['chongzhi'];
				pdo_update($this->table_students,array('chongzhi'=>$new),array('id'=>$sid));
				$data_chongzhilog = array(
					'schoolid' 	=> $order['schoolid'],
					'weid'	   	=> $order['weid'],
					'sid'	   	=> $order['sid'],
					'yue_type' 	=> 2,
					'cost_type' => 1,
					'cost'	   	=> $taocan['chongzhi'],
					'costtime' 	=> $order['paytime'],
					'orderid'  	=> $order['id'], 
					'on_offline' => 1,
					'createtime' => time()
				);
				pdo_insert($this->table_yuecostlog,$data_chongzhilog);
				$send = $this->sendMobileJfjgtz($order['id']);
			}else if($order['type'] == 4){
				$sign = pdo_fetch("SELECT name,nj_id FROM " . tablename($this->table_signup) . " where :id = id", array(':id' => $order['signid']));
				$njinfo = pdo_fetch("SELECT tid FROM " . tablename($this->table_classify) . " WHERE :sid = sid ", array(':sid' => $sign['nj_id']));
				$njzr = pdo_fetch("SELECT openid FROM " . tablename($this->table_teachers) . " WHERE :id = id ", array(':id' => $njinfo['tid']));
				if(!empty($njzr)){
					$this->sendMobileBmshtz($order['signid'], $order['schoolid'], $order['weid'], $njzr['openid'], $sign['name']);
				}			
			}else{
				$this->sendMobileJfjgtz($order['id']);
			}
			mload()->model('print');
			order_print($order['id']);	
			if($params['chongzhi'] == 'chongzhi'){
				$data_yuelog = array(
					'schoolid' 	=> $order['schoolid'],
					'weid'	   	=> $order['weid'],
					'sid'	   	=> $order['sid'],
					'yue_type' 	=> 2,
					'cost_type' => 2,
					'cost'	   	=> $order['cose'],
					'costtime' 	=> $order['paytime'],
					'orderid'  	=> $order['id'],
					'on_offline' => 1,
					'createtime' => time()
				);
				pdo_insert($this->table_yuecostlog,$data_yuelog);
				$params['from'] = 'return';
			}
		}
		if (empty($params['result']) || $params['result'] != 'success') {
			 pdo_update($this->table_wxpay, array('status' => 1), array('id' => $orderid));
			 pdo_update($this->table_order, array('status' => 1), array('id' => $wxpay['od1']));
			 $order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where id = :id ", array(':id' => $wxpay['od1']));
			 if(!empty($order['morderid']) && $order['type'] == 6 ){
				pdo_update($this->table_mallorder, array('status' => 1), array('id' => $order['morderid']));
			}
			 
		}
		if ($params['from'] == 'return') {
			$lala .= "12345";
			//message($lala);	
		 $order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where id = :id ", array(':id' => $wxpay['od1']));	
		 $teaid = pdo_fetch("SELECT * FROM " . tablename($this->table_mallorder) . " where id = :id ", array(':id' => $order['morderid']));
			if($order['type'] == 4){	
				$url = $_W['siteroot'] . 'app/index.php?i=' . $wxpay['weid'] . '&c=entry&schoolid=' . $wxpay['schoolid'] . '&id=' . $order['signid'] . '&do=signupjc&m=fm_jiaoyu';
			}else if($order['type'] == 5){		
				$url = $_W['siteroot'] . 'app/index.php?i=' . $wxpay['weid'] . '&c=entry&schoolid=' . $wxpay['schoolid'] . '&do=user&m=fm_jiaoyu';
			}else if($order['type'] == 7){		
				$url = $_W['siteroot'] . 'app/index.php?i=' . $wxpay['weid'] . '&c=entry&schoolid=' . $wxpay['schoolid'] . '&do=user&m=fm_jiaoyu';
			}else if($order['type'] == 6){	
				if(!empty($teaid['tid']) && empty($teaid['sid'])){
					$url = $_W['siteroot'] . 'app/index.php?i=' . $wxpay['weid'] . '&c=entry&schoolid=' . $wxpay['schoolid'] . '&do=getorder&m=fm_jiaoyu';
				}else{
					$url = $_W['siteroot'] . 'app/index.php?i=' . $wxpay['weid'] . '&c=entry&schoolid=' . $wxpay['schoolid'] . '&do=sgetorder&userid='.$teaid['userid'].'&op=yes_g&m=fm_jiaoyu';
				}
			}
			else{
				$url = $_W['siteroot'] . 'app/index.php?i=' . $wxpay['weid'] . '&c=entry&schoolid=' . $wxpay['schoolid'] . '&do=user&m=fm_jiaoyu';
			}
			if ($params['result'] == 'success') {
				message('支付成功！', $url, 'success');
			} else {
				message('支付失败！', $url);
			}
		}
	}

	public function uniarr($uniarr, $id) {
		foreach ($uniarr as $key => $value) {
			if ($id == $value) {
				return true;
			}
		}
		return false;
	}

	public function checkpay($schoolid, $sid, $userid, $uid) {
		global $_W, $_GPC;

		$student = pdo_fetch("SELECT * FROM " . tablename($this->table_students) . " WHERE :weid = weid And :schoolid = schoolid And :id = id", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid, ':id' => $sid));
		$cost = pdo_fetchall("SELECT * FROM " . tablename($this->table_cost) . " where weid = :weid And schoolid = :schoolid And is_on = :is_on ", array(':weid' => $_W['uniacid'], ':schoolid' => $schoolid, ':is_on' => 1));

		foreach ($cost as $key => $value) {
			$bjarr = explode(',',$value['bj_id']);
			$is = $this->uniarr($bjarr, $student['bj_id']);
			//print_r($bjarr);
			if ($is) {
				//$bjstatus = true;
				$orderst = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " where weid = :weid And schoolid = :schoolid And obid = :obid And costid = :costid And sid = :sid And type = :type ", array(
							':weid' => $_W['uniacid'],
							':schoolid' => $schoolid,
							':costid' => $value['id'],
							':obid' => $value['about'],
							':sid' => $sid,
							':type' => 3
							));
				if (empty($orderst)) {
					$orderid = "{$uid}{$sid}";
						$date = array(
							'weid' =>  $_W['uniacid'],
							'schoolid' => $schoolid,
							'sid' => $sid,
							'userid' => $userid,
							'type' => 3,
							'status' => 1,
							'obid' => $value ['about'],
							'costid' => $value ['id'],
							'uid' => $uid,
							'cose' => $value['cost'],
							'payweid' => $value['payweid'],
							'orderid' => $orderid,
							'createtime' => time(),
						);
					pdo_insert($this->table_order, $date);
				}
			}
		}
	}

	public function checkobjiect($schoolid, $sid, $obid) {

		global $_W, $_GPC;

		$order = pdo_fetchall("SELECT costid,paytime,status FROM " . tablename($this->table_order) . " where weid = :weid And schoolid = :schoolid And sid = :sid And type = :type And obid = :obid ORDER BY id DESC LIMIT 0,1", array(
				':weid' => $_W['uniacid'],
				':schoolid' => $schoolid,
				':sid' => $sid,
				':obid' => $obid,
				':type' => 3,
				));
		foreach ($order as $key => $value) {
			$cost = pdo_fetch("SELECT * FROM " . tablename($this->table_cost) . " where weid = :weid And schoolid = :schoolid And is_on = :is_on  And id = :id", array(
					':weid' => $_W['uniacid'],
					':schoolid' => $schoolid,
					':id' => $value['costid'],
					':is_on' => 1
					));
			if (!empty($cost)){
				if ($value['status'] == 2) {
					if ($cost['is_time'] == 1){
						if($cost['endtime'] < TIMESTAMP){
							$stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('obinfo', array('id' => $value['costid'], 'schoolid' => $schoolid, 'type' => 1));
							header("location:$stopurl");
						}else if($cost['starttime'] > TIMESTAMP){
							$stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('obinfo', array('id' => $value['costid'], 'schoolid' => $schoolid, 'type' => 2));
							header("location:$stopurl");
						}
					}else{
						$time = $cost['dataline'] * 86400;
						$times = $time + $value['paytime'];
						$rest = $times - TIMESTAMP;
						$restday = $rest/86400;
						if ($restday < 0){
							$stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('obinfo', array('id' => $value['costid'], 'schoolid' => $schoolid, 'type' => 1));
							header("location:$stopurl");
						}
					}
				}else{
					$stopurl = $_W['siteroot'] .'app/'.$this->createMobileUrl('obinfo', array('id' => $value['costid'], 'schoolid' => $schoolid, 'type' => 1));
					header("location:$stopurl");
				}
			}
		}
	}
	
	public function imessage($msg, $redirect = '', $type = '', $tip = '', $btn_text = '确定') {
			global $_W;
			if ($redirect == 'refresh') {
				$redirect = $_W['script_name'] . '?' . $_SERVER['QUERY_STRING'];
				var_dump( $redirect);
			} elseif (!empty($redirect) && !strexists($redirect, 'http://')) {
				$urls = parse_url($redirect);
				$redirect = $_W['siteroot'] . 'web/index.php?' . $urls['query'];
			}
			if ($redirect == '') {
				$type = in_array($type, array('success', 'error', 'info', 'ajax')) ? $type : 'info';
			} else {
				$type = in_array($type, array('success', 'error', 'info', 'ajax')) ? $type : 'success';
			}
			$label = $type;
			if($type == 'error') {
				$label = 'danger';
			}
			if($type == 'ajax' || $type == 'sql') {
				$label = 'warning';
			}			
			include $this->template('public/message', TEMPLATE_INCLUDEPATH);
			die;
	}
	
	public function GetSensitiveWord ($weid){
		$word = pdo_fetch("SELECT sensitive_word FROM " . tablename('wx_school_set') . " WHERE weid = {$weid}");
		return $word['sensitive_word'];
	}
	
	public function getAccessToken2() { 
		global $_GPC, $_W;
		load()->func('communication');
		load()->classs('weixin.account');		
		$account_api = WeAccount::create();
		$token = $account_api->getAccessToken();
		return $token;
	}
	public function getAccessToken3($weid) {//返回原来TOKEN
		global $_GPC, $_W;
		load()->func('communication');
		load()->classs('weixin.account');
		$jsauth = pdo_fetch("SELECT * FROM " . tablename('account_wechats') . " WHERE uniacid = '{$weid}'");
		$uniacccount = WeAccount::create($jsauth['acid']);
		$token = $uniacccount->getAccessToken();
		return $token;
	}
}
if(getoauthurl() == 'edu.d3xf.com'){
	define('NJNAME', '机构');
	define('NJNAMEGL', '机构管理');
}else{
	define('NJNAME', '年级');
	define('NJNAMEGL', '年级管理');
}
