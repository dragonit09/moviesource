<?php
if (!defined('RK_MEDIA')) {
	header("HTTP/1.0 404 Not Found");
	echo "No input file specified.";
}
include View::TemplateView('header');
$phpFastCache = phpFastCache();
$data_cache = $phpFastCache->get("li_info_$filmid");
if($data_cache == null){
	$filmz = json_encode(MySql::dbselect("title,title_en,category,country,thumb,director,actor,year,duration,viewed,content,keywords,total_votes,total_value,trailer,quality,slug,big_image",'film',"id = '$filmid'"));
	if($filmz != '') {$phpFastCache->set("li_info_$filmid", $filmz, 72000);}
}
else {
	$filmz = $data_cache;
}
$film = json_decode($filmz,true);
$title = $film[0][0];
$title_en = $film[0][1];
$slug = $film[0][16];
if(!$epwatch) $watchurl = "javascript:void(0);";
else $watchurl = get_url($filmid,$slug,'Phim')."xem-phim.html";
$urlfilm = get_url($filmid,$slug,'Phim');
$big_thumb = $film[0][17];
if(!$big_thumb) $big_thumb = SITE_URL.'/assets/images/default_new.jpg';
$thumb = $film[0][4];
if(!$thumb) $thumb = TEMPLATE_URL.'images/grey.jpg';
$theloai = category_a($film[0][2]);
$quocgia = country_a($film[0][3]);
$genre = category_ad($film[0][2]);
$daodien = CheckName($film[0][5]);	
$dienvien = CheckName($film[0][6]);
$year = CheckName($film[0][7]);
$duration = CheckName($film[0][8]);
$viewed = $film[0][9];
$content = html_entity_decode($film[0][10]);
$tags = GetTag_a($film[0][11],5);
$Astar = $film[0][12];
$Bstar = $film[0][11];
$Cstar = ($Astar/$Bstar);
$Dstar = number_format($Cstar,0);
$Cstar = number_format($Cstar,1);
for($i=1;$i<11;$i++) {
	$votes .= "<div class=\"vote-line-hv\" data-id=\"$i\"></div>";
}
$tl = $film[0][14];
$tl1 = explode('watch?v=',$tl);
$trailer = $tl1[1];
$quality = $film[0][15];
$episodeid = $epid[0][0];
$epurl = $epid[0][3];
$urlep = SITE_URL.$cururl;
$epsubtitle = $epid[0][4];
$tracks = getSub($episodeid);
?>
<style>
.player-ads {
	width:100%;
}
</style>
<div class="pad"></div>
<div class="quang-cao" style="width:728px;margin:auto;">
		
</div>
<div class="clearfix"></div>
<div class="clearfix"></div>
<div class="main-content main-detail">
	<div class="main-content main-category">
		<div id="bread">
			<ol class="breadcrumb">
				<li><a href="<?=SITE_URL?>/">Home</a></li>
				<li class="active"><a href="<?=$urlfilm;?>"><?=$title?></a></li>
			</ol>
		</div>
		<div id="mv-info">
		<?php if($idep) { ?>
			<div player-token="<?=$id?>" style="height: 550px;width:100%;position: relative;" id="media-player" movie-id="<?=$filmid?>">
				<img src="/uploads/loading.svg" style="position: absolute;top: 0; bottom:0; left: 0; right:0;margin: auto;">
				<script>
				$(document).ready(function () {
					get_player("<?php echo aes_encrypt($epurl,$key,$iv_size);?>","<?php echo aes_encrypt($big_thumb,$key,$iv_size);?>","<?php echo aes_encrypt($tracks,$key,$iv_size);?>");
				});
				</script>
			</div>
			<div id="bar-player">
				<a href="#mv-info" class="btn bp-btn-light"><i class="fa fa-lightbulb-o"></i> <span></span></a>
				<span id="button-favorite">
					<a onclick="favorite(<?=$filmid?>,1)" class="btn bp-btn-like"><i class="fa fa-heart"></i>Yêu Thích</a>
				</span>
				<span>
					<a href="#commentfb" class="btn bp-btn-review"><i class="fa fa-comments"></i><span>Bình Luận</span></a>
				</span>
				<span id="button-favorite">
					<a onclick="error(<?=$filmid?>,<?=$episodeid?>)" class="btn bp-btn-error"><i class="fa fa-warning"></i>Báo lỗi</a> 
				</span>
				<span id="remove-ad">
					<a class="btn bp-btn-close-ads"><i class="fa fa-ban"></i><span>Tắt QC</span></a>
				</span>
				<span class="bp-view"><i class="fa fa-eye mr10"></i><?=number_format($viewed)?></span>
				<!--Server Dự phòng-->
				<div class="clearfix"></div>
				<div class="quang-cao" style="margin: auto;width: 728px;">
					<?=viewads("under_player_desktop");?>
				</div>
				<div class="clearfix"></div>
				 <!-- OverlayPlayer -->
					<div class="quang-cao">
					<script>
					 				        var adsW = 728;
					 				        var adsBottom = 55;
					 				        if ($('#bar-player').width() >= 720) {
					 				            var code = '<div id=\"adtrue_tag_8877\"></div><script data-cfasync=\'false\' type=\'text/javascript\' src=\'//cdn.adtrue.com/rtb/async.js\' async><\/script><script type=\"text/javascript\">var adtrue_tags = window.adtrue_tags || [];adtrue_tags.push({tag_id: 8877,width: 728,height: 90});<\/script>';
					 				        }
					 				        document.write('<div id="ads_location" class="player-ads-bottom" style="width: ' + adsW + 'px;bottom: ' + adsBottom + 'px;">' + code + '<div class="player-ads-bottom-close" style="background:#404040;color:#4caf50"><a>Close [X]</a></div></div>');
					 									        
					    </script>
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
			<div id="list-eps">
				<?=list_episode($filmid,$title);?>
			</div>
			<script>
				$("a.btn-eps").removeClass("active");
				$("a.btn-eps[id="+<?php echo $idz;?>+"]").addClass("active");
			</script>
	<?php
	} else { 
	?>
			<a href="<?=$watchurl?>" title="Xem phim <?=$title."-".$title_en?>" class="thumb mvi-cover" style="background-image: url('<?=$big_thumb?>')">
				<span class="mvi-view"><i class="fa fa-eye mr10"></i><?=number_format($viewed)?></span>
			</a>
	<?}?>
			<div class="mvi-content">
					<div class="mvic-btn">
					<div class="mv-rating">
					</div>
					<div class="clearfix"></div>
					<? if(!$idep) { ?><a href="<?=$watchurl?>" class="btn btn-block btn-lg btn-successful btn-01"><i class="fa fa-play mr10"></i>Xem Phim</a><?}?>
					<div class="clearfix"></div>
					<div class="quang-cao">
						<?=viewads("banner_sidebar");?>					
					</div>
					<div class="clearfix"></div>
					</div>

				<div class="thumb mvic-thumb" style="background-image: url(<?=$thumb?>);"></div>
				<? if($season) echo $html_season; ?>
				<div class="mvic-desc">
					<h3 class="name_vn"><?php echo $title; ?><?php if($title_en){?> - <?php echo $title_en; }?></h3>
					<?if($tl){?>
					<div class="block-trailer">
						<a data-target="#pop-trailer" data-toggle="modal" class="btn btn-primary"><i class="fa fa-video-camera mr5"></i>Trailer</a>
					</div>
					<?}?>
					<div class="desc more">
					<?
						$output = strip_tags(nl2br($content), '<a><h1><img><b><strong><br>');
						echo $output;
					?>
					</div>
					<div class="mvic-info">
						<div class="mvici-left">
							<p><strong>Thể loại: </strong><?php echo $theloai; ?></p>
							<p><strong>Diễn viên: </strong><?php echo $dienvien; ?></p>
							<p><strong>Đạo diễn: </strong><?php echo $daodien; ?></p>
							<p><strong>Quốc gia: </strong><?php echo $quocgia; ?></p>
						</div>
						<div class="mvici-right">
						<p><strong>Thời lượng:</strong> <?php echo $duration; ?></p>
						<p><strong>Chất lượng:</strong> <span class="quality"><?php echo $quality;?></span></p>
						<p><strong>Năm phát hành:</strong> <?php echo $year;?></p>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>
					<div class="quang-cao" style="width: 728px;height:90px;margin:auto">
					
					</div>
				</div>
				<div class="clearfix"></div>
				
			</div>
		<script type="text/javascript">
			$(document).ready(function () {
				$.get(base_url + 'ajax/movie_rate_info/' + '<?=$filmid?>/', function (data) {
					$('.mv-rating').html(data);
				})
			})
		</script>
		</div>
		<div id="mv-keywords">
			<strong class="mr10">Keywords:</strong><?=$tags?>                   
		</div>
	</div>

	<?php
	function setCookiePOP(){
	if(!isset($_COOKIE['pop_cookie'])) {
          setcookie('pop_cookie', 'ON', time() + (60*30), "/");
          return CheckIP(); 
      }  
	} 
	function CheckIP(){
    $get = file_get_contents('https://freegeoip.net/json/'.$_SERVER['REMOTE_ADDR']);
    $data = json_decode($get,true);
    	if ($data["country_code"] !=="VN") {
      	echo '<div id="container-popup">
 				<div class="popup">
 				<p class="pheader">PLEASE SIGN UP TO CONTINUE...</p>
 				<p class="pbody">
 				<a class="pbutton bounceIn" title="Sign up to continue.." href="https://app.yoonla.com/evolve?a_aid=5ae9e34942316">SIGN UP NOW</a>	
 				</p>		
 				</div>
 				</div>';;
    	}
  	} 
  ?>
<!-- <?=setCookiePOP();?>  -->
<!--related-->
	<div id="commentfb"><div class="fb-comments" data-order-by="reverse_time" data-href="<?php echo $urlfilm;?>" data-width="100%" data-numposts="5"></div></div>
	<div class="movies-list-wrap mlw-related">
		<div class="ml-title ml-title-page">
			<span>Có Thể Bạn Muốn Xem</span>
		</div>
		<div class="movies-list movies-list-full">               
			<?php echo rand2($title,$filmid);?>
			<script type="text/javascript">
			/*$('.jt').qtip({
				content: {
					text: function (event, api) {
						$.ajax({
							url: api.elements.target.attr('data-url'),
							type: 'GET',
							success: function (data, status) {                         
								api.set('content.text', data);
							}
						});
					},
					title: function (event, api) {
						return $(this).attr('title');
					}
				},
				position: {
					my: 'top left', 
					at: 'top right', 
					viewport: $(window),
					effect: false,
					target: 'mouse',
					adjust: {
						mouse: false 
					},
					show: {
						effect: false
					}
				},
				hide: {
					fixed: true
				},
				style: {
					classes: 'qtip-light qtip-bootstrap'
				}
			});*/
			$("img.lazy").lazyload({
				effect: "fadeIn"
			});
			</script>
		</div>
	</div>
</div>
<div id="overlay"></div>
<div class="modal fade modal-cuz modal-trailer" id="pop-trailer" tabindex="-1" role="dialog"
	 aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
						class="fa fa-close"></i>
				</button>
				<h4 class="modal-title" id="myModalLabel">Trailer: <?=$title?></h4>
			</div>
			<div class="modal-body">
				<div class="modal-body-trailer">
					<iframe width="100%" height="315" src="https://www.youtube.com/embed/<?=$trailer?>" frameborder="0" allowfullscreen></iframe>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function () {
		$('.bp-btn-light, .bp-btn-review').smoothScroll();
		$('#comment-area #comment .content').perfectScrollbar();
		getCommentCount();
		if (is_login) {
			$.get(base_url + 'ajax/movie_check_favorite/' + '<?=$filmid?>/', function (data) {
				$('#button-favorite').html(data);
			});
		}
		$("#toggle-schedule").click(function (e) {
			$("#toggle-schedule").toggleClass("active");
			$(".se-list").toggle();
		});
	});

	function getCommentCount() {
		$.ajax({
			url: 'https://graph.facebook.com/?id=<?php echo $urlfilm;?>',
			dataType: 'jsonp',
			success: function (data) {
				if (data.comments) {
					$("#comment-count").text(data.comments);
				}
			}
		});
	}
	$('.player-ads-bottom-close a').on('click', function() { 
	            var contentDiv = $('.player-ads-bottom');
	             contentDiv.hide();
	            }
			 );
</script>
<div class="quang-cao">
	<div id="divAdRight" style="display: block; position: fixed; top: 70px;z-index: 10;">
	    <?=viewads("float_right");?>        
	</div>
</div>
<div class="quang-cao">
	<div id="divAdLeft" style="display: block; position: fixed; top: 70px;z-index: 10 ;">
	    <?=viewads("float_left");?>
	</div>
</div>
<?php
include View::TemplateView('footer');

?>
