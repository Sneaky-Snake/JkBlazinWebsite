<?php
	function curl_get_contents($url) {
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		$data = curl_exec($curl);
		curl_close($curl);
		return $data;
	} function get_latest_video($api, $pid) {
		$url="https://www.googleapis.com/youtube/v3/playlistItems?part=contentDetails&maxResults=1&playlistId=".$pid."&key=".$api;
		$data= curl_get_contents($url);
		$data= json_decode($data, true );
		$data= $data ["items"];
		$data= $data[0];
		$data= $data ["contentDetails"];
		$data= $data ["videoId"];
		$results = $data;
		//if a video was found
		if($results) {
			//generate the code required to embed the video.
			$embedCode = '<iframe id="VideoPlayer" src="https://www.youtube-nocookie.com/embed/'.$results.'?rel=0" frameborder="0" allowfullscreen></iframe>';
			//echo the embed code
			echo $embedCode;
		} else {
			echo 'No Video Found.';
		}
	} function get_video_listing($api, $pid, $mres, $reverse) {
      	$count = ($reverse ? $mres-1 : 0);
		$url = "https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=".$mres."&playlistId=".$pid."&key=".$api;
		$data = curl_get_contents($url);
		$data = json_decode($data, true );
		
		for (;$mres > 0;$mres --) {
			$result = $data ["items"] [$count] ["snippet"];
			$resulttitle = $result ["title"];
			$resultid = $result ["resourceId"] ["videoId"];
			echo '<li><a href="watch?videoId='.$resultid.'" class="ListLinks">'.$resulttitle.'</a></li>';
          	$reverse ? $count-- : $count ++;
		}
	} function get_specific_video($vid) {
		echo '<iframe id="VideoPlayer" src="https://www.youtube-nocookie.com/embed/'.$vid.'?rel=0" frameborder="0" allowfullscreen></iframe>';
	} function get_latest_blogpost($api, $bid) {
		$url="https://www.googleapis.com/blogger/v3/blogs/".$bid."/posts?key=".$api;
		$data= curl_get_contents($url);
		$data= json_decode($data, true);
		$data= $data ["items"];
		$data= $data [0];
		$postTitle= $data ["title"];
		$postContent= $data ["content"];
		echo $postTitle;
		echo $postContent;
	}
?>
