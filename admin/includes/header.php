<?php
ob_start();
include_once '../core/dao/Database.php';
include_once '../core/resource/AdminFunctions.php'; 
include_once '../core/resource/UserFunctions.php';
include_once '../core/resource/AdminFunctions.php';
include_once '../core/dao/UserDAO.php';
include_once '../core/dao/AdminDAO.php';
include_once '../core/model/VideoFileUtility.php';
include_once '../core/bean/VideoDetails.php';
include_once '../core/constants/Constants.php';
include_once '../core/bean/Genre.php';
include_once '../core/bean/Comment.php';

include_once 'includes/thumbnail.php';
include_once '../includes/pagination.php';
include_once 'includes/videodescription.php';

$userFunctions = new UserFunctions();
$adminFunctions = new AdminFunctions();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head><title>Movies Lover</title>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=UTF-8">
<link rel="stylesheet" href="../css/menu.css" type="text/css" />
<link rel="stylesheet" href="../css/style.css" type="text/css" />
<link rel="stylesheet" href="../css/table.css" type="text/css" />
<link rel="shortcut icon" href="../images/favicon.png">
<!--[if IE]>
	<link rel="stylesheet" type="text/css" href="../css/table_ie.css" />
<![endif]-->
<script type="text/javascript" src="../js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="../js/jquery.validate.js"></script>

<script type="text/javascript" src="../js/tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
	$().ready(function() {
		$('textarea.text').tinymce({
			// Location of TinyMCE script
			script_url : '../js/tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap, iespell, advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "none",
			theme_advanced_resizing : true,

			// Example content CSS (should be your site CSS)
			content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",
		});
	});

	$('#submit').click(function() {
	     tinymce.triggerSave();
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
			var validator = $("#commentForm").submit(function() {
				// update underlying textarea before submit validation
				tinyMCE.triggerSave();
			}).validate({
				ignore: "",
				rules: {
					title: "required",
					content: "required"
				},
				errorPlacement: function(label, element) {
					// position error label after generated textarea
					if (element.is("textarea")) {
						label.insertAfter(element.next());
					} else {
						label.insertAfter(element)
					}
				}
			});
			validator.focusInvalid = function() {
				// put focus on tinymce on submit validation
				if( this.settings.focusInvalid ) {
					try {
						var toFocus = $(this.findLastActive() || this.errorList.length && this.errorList[0].element || []);
						if (toFocus.is("textarea")) {
							tinyMCE.get(toFocus.attr("id")).focus();
						} else {
							toFocus.filter(":visible").focus();
						}
					} catch(e) {
						// ignore IE throwing errors when focusing hidden elements
					}
				}
			}
	});
</script>
</head>
<body>
	<table class="containertable">
		<tr>
			<td colspan="2">
				<a href="newvideos.php">
					<img alt="Movies Lover" src="../images/movies-logo.png" />
				</a>
				<div style="background-image:url(../images/center_tile.gif)">
					<table cellpadding=0 cellspacing=0 style="width:100%;">
						<tr>
							<td><div style="font-size:1px;width:6px;height:34px;background-image:url(../images/left_cap.gif);"></div></td>
							<td style="width:100%;">
								<ul id="qm0" class="qmmc">
									<li><a href="newvideos.php">Add New Videos</a></li>
									<li><span class="qmdivider qmdividery" ></span></li>
									<li><a href="editgenres.php">Edit Genres</a></li>
									<li><span class="qmdivider qmdividery" ></span></li>
									<li><a href="editvideos.php">Edit Videos</a></li>
									<li><span class="qmdivider qmdividery" ></span></li>
									<li><a href="logout.php">Logout</a></li>
							</td>
						</tr>
					</table>
				</div>
			</td>
		</tr>
		<tr>