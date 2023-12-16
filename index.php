<?php
//更多精品源码微信搜索：一片净土OSi
//同款多种业务收徒联系微信：Ju20-00
	$c = $_GET['c'];
	$url ='https://m.kanman.com/';
	$main = array(
				'appname' => '漫画',
				'banner'=> "",
				'chapin'=> "",
				'gezi'=> "",
				'id'=> "1",
				'jili'=> "",
				'share'=> "",
				'shipin'=> "",
				'statu'=>"1",
				'yuansheng'=> "",
			);
	switch ($c) {
		case 'peizhi':
			$html = file_get_contents($url);
			preg_match('/<ul class="swiper-wrapper">(.*?)<\/ul>/mis', $html, $banner);
			preg_match_all('/<li class="card swiper-slide">(.*?)<\/li>/s', $banner[1], $itm);
			$title = array();
			$img = array();
			$id = array();
			for ($i = 0; $i < sizeof($itm[1]); $i++) {
			    //获取标题
			    preg_match('/title="(.*?)">/',$itm[1][$i], $tit);
			         array_push($title, $tit[1]);
			    //链接
			    preg_match('/href="\/(.*?)\/"/', $itm[1][$i], $h);
			         array_push($id, $h[1]);
			    //封面图
			    preg_match('/data-src="(.*?)"/', $itm[1][$i], $mg);
			         array_push($img, $mg[1]);
			   // preg_match_all('/<p class="actor">(.*?)<\/p>/s', $newhot3[1][$n], $actor);
			  //         array_push( $actors,  $actor[1]);
			  //   preg_match('/<p class="other"><i>(.*?)<\/i><\/p>/', $newhot3[1][$n], $statu);
			  //         array_push($status, $statu[1]);
			}
			$bannerData['title']= $title;
			$bannerData['id']= $id;
			$bannerData['imgurl']= $img;
			
			$data['main'] = $main;
			$data['banner'] = $bannerData;
			echo json_encode($data);
			break;
		case 'manhua':
			$id = $_GET['id'];
			$html = file_get_contents($url.$id);
			preg_match('/<div class="comic-detail-cover" id="detail">(.*?)<\/div><div class="comic-box">/mis', $html, $header);
			preg_match('/<h1 class="comic-title".*?title="(.*?)"/mis', $header[1], $title);
			preg_match('/<i class="comic-icon-title comic-produce">(.*?)<\/i>/mis', $header[1], $proud);
			preg_match('/<p class="comic-popular">人气<strong>(.*?)<\/strong>/mis', $header[1], $popular);
			  
			preg_match('/<ul class="comic-tags">(.*?)<\/ul>/mis', $header[1], $tags);
			preg_match_all('/<li class="item">.*?">(.*?)<\/a>/s', $tags[1], $tag);
			
			preg_match('/<div class="thumb">.*?data-src="(.*?)"/mis', $header[1], $img);
			preg_match('/<div class="comic-describe-wrap">.*?>(.*?)<i/mis', $html, $dec);
			
			preg_match('/作者<\/h3>.*?<ul.*?>(.*?)<\/ul>/mis', $html, $author);
			preg_match_all('/<li.*?">(.*?)<\/li>/s', $author[1], $at);
			$ator =  array();
			for($i=0; $i<sizeof($at[1]); $i++){
			    preg_match('/<h4.*?<a.*?>(.*?)<\/a>/',$at[1][$i], $aname);
			    preg_match('/data-src="(.*?)"/',$at[1][$i], $apic);
			    preg_match('/<figcaption class="figcaption">(.*?)<\/figcaption>/',$at[1][$i], $afigcaption);
			    array_push($ator,'{"name":"'.$aname[1].'",'.'"pic":"'.$apic[1].'",'.'"fig":"'.$afigcaption[1].'"}');
			};
			
			preg_match('/角色<\/h3>.*?<ul.*?>(.*?)<\/ul>/mis', $html, $role);
			preg_match_all('/<li.*?">(.*?)<\/li>/s', $role[1], $rl);
			$rol =  array();
			for($i=0; $i<sizeof($rl[1]); $i++){
			    preg_match('/<h4.*?<a.*?>(.*?)<\/a>/',$rl[1][$i], $rname);
			    preg_match('/data-src="(.*?)"/',$rl[1][$i], $rpic);
			    preg_match('/<figcaption class="figcaption">(.*?)<\/figcaption>/',$rl[1][$i], $rfigcaption);
			    array_push($rol,'{"name":"'.$rname[1].'",'.'"pic":"'.$rpic[1].'",'.'"fig":"'.$rfigcaption[1].'"}');
			};
			
			
			preg_match('/id="catalog">.*?<div class="bd">(.*?)<\/div><\/div>/mis', $html, $catalog);
			preg_match('/<p class="comic-update-status">(.*?)<\/p>/mis', $catalog[1], $status);
			preg_match('/<ul.*?(.*?)<\/ul>/mis', $catalog[1], $list);
			preg_match_all('/<li.*?">(.*?)<\/li>/s', $list[1], $li);
			$lst =  array();
			for($i=0; $i<sizeof($li[1]); $i++){
			    preg_match('/title="(.*?)"/',$li[1][$i], $tit);
			    preg_match('/<time class="update-time">(.*?)<\/time>/',$li[1][$i], $time);
			    preg_match('/<a href="(.*?)"/',$li[1][$i], $href);
			    preg_match('/<span class="num">(.*?)<\/span>/',$li[1][$i], $numb);
			    array_push($lst,'{"title":"'.$tit[1].'",'.'"uptime":"'.$time[1].'",'.'"url":"'.$href[1].'",'.'"support":"'.$numb[1].'"}');
			};
			
			$Data['title'] = $title[1];
			$Data['renqi'] = $popular[1];//人气
			$Data['tag'] = $tag[1];//标签
			$Data['img'] = $img[1];
			$Data['dec'] = $dec[1];
			$Data['author'] = $ator;//作者
			$Data['role'] = $rol;//角色
			$Data['catalog'] = $lst;//目录
			$Data['statu'] = $status[1];
			$Data['main'] = $main;
			echo json_encode($Data);
			break;
		default:
			echo 1;
			break;
		
		}
	