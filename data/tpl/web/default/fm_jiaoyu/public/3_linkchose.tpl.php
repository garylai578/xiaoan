<?php defined('IN_IA') or exit('Access Denied');?><span class="input-group-btn">
<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" type="button" aria-haspopup="true" aria-expanded="false">选择链接 <span class="caret"></span></button>
<ul class="dropdown-menu">
	<li><a href="javascript:" data-type="jiaoyu" onclick="showJiaoyuDialog('url<?php  echo $row['id'];?>',2);">微教育菜单</a></li>
	<li><a href="javascript:" data-type="system" onclick="showLinkDialog(this);">系统菜单</a></li>
	<li><a href="javascript:" data-type="page" onclick="pageLinkDialog(this);">微页面</a></li>
	<li><a href="javascript:" data-type="article" onclick="articleLinkDialog(this)">文章及分类</a></li>
	<li><a href="javascript:" data-type="news" onclick="newsLinkDialog(this)">图文回复</a></li>
	<li><a href="javascript:" data-type="map" onclick="mapLinkDialog(this)">一键导航</a></li>
	<li><a href="javascript:" data-type="phone" onclick="phoneLinkDialog(this)">一键拨号</a></li>
</ul>
</span>