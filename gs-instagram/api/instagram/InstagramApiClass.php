<?php
/**
 * Instagram Basic Display API Developed by Gaurav Sharma gaurav@gmail.com
 * https://developers.facebook.com/docs/instagram-basic-display-api
 * @package api/instagram/InstagramApiClass
 * @version 1.0.0
 */

class InstagramApiClass{

	/**
	 * @since 1.0.0
	 * @return array of access token
	 * @param string $client_id, $client_secret, $redirect_uri, $code
	 */ 
	public function get_short_lived_access_token($client_id, $client_secret, $redirect_url, $code){

		$curl = curl_init();

        $post_fields = array(
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'grant_type' => 'authorization_code',
            'redirect_uri' => $redirect_url,
            'code' => $code
        );

        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://api.instagram.com/oauth/access_token",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "POST",
          CURLOPT_POSTFIELDS => $post_fields,
          CURLOPT_HTTPHEADER => array(
            "Cookie: ig_did=4700D898-5981-473B-A179-2C06BE30B7F5; mid=XoconQAEAAF9bpljM4tGxzZxVYDs; csrftoken=fy0n0sLeusrMupwAnMcmeRCjsMoGNOBe; rur=PRN"
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
      
        $response = json_decode($response);

        return $response;
	}

	/**
	 * @since 1.0.0
	 * @return array of long lived access token
	 * @param string $client_secret, $short_live_access_token
	 */ 
	public function get_long_lived_access_token($client_secret, $short_live_access_token){

	    $curl = curl_init();

	    curl_setopt_array($curl, array(
	      CURLOPT_URL => "https://graph.instagram.com/access_token?grant_type=ig_exchange_token&client_secret=".$client_secret."&access_token=".$short_live_access_token,
	      CURLOPT_RETURNTRANSFER => true,
	      CURLOPT_ENCODING => "",
	      CURLOPT_MAXREDIRS => 10,
	      CURLOPT_TIMEOUT => 0,
	      CURLOPT_FOLLOWLOCATION => true,
	      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	      CURLOPT_CUSTOMREQUEST => "GET",
	      CURLOPT_HTTPHEADER => array(
	        "Cookie: ig_did=4700D898-5981-473B-A179-2C06BE30B7F5; mid=XoconQAEAAF9bpljM4tGxzZxVYDs; csrftoken=fy0n0sLeusrMupwAnMcmeRCjsMoGNOBe"
	      ),
	    ));

	    $response = curl_exec($curl);

	    curl_close($curl);

	    $response = json_decode($response);

	    return $response;
	}

	/**
	 * @since 1.0.0
	 * @return array of refresh long lived access token
	 * @param string $long_live_access_token
	 */
	public function refresh_long_lived_access_token($long_live_access_token){

		$curl = curl_init();

	    curl_setopt_array($curl, array(
	      CURLOPT_URL => "https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=".$long_live_access_token,
	      CURLOPT_RETURNTRANSFER => true,
	      CURLOPT_ENCODING => "",
	      CURLOPT_MAXREDIRS => 10,
	      CURLOPT_TIMEOUT => 0,
	      CURLOPT_FOLLOWLOCATION => true,
	      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	      CURLOPT_CUSTOMREQUEST => "GET",
	      CURLOPT_HTTPHEADER => array(
	        "Cookie: ig_did=4700D898-5981-473B-A179-2C06BE30B7F5; mid=XoconQAEAAF9bpljM4tGxzZxVYDs; csrftoken=fy0n0sLeusrMupwAnMcmeRCjsMoGNOBe"
	      ),
	    ));

	    $response = curl_exec($curl);

	    curl_close($curl);
	    
	    $response = json_decode($response);

	    return $response;

	}

	/**
	 * @since 1.0.0
	 * @return array of user profile
	 * @param string $user_id, $access_token
	 */
	public function get_user_profile($user_id, $access_token){

	    $curl = curl_init();

	    curl_setopt_array($curl, array(
	      CURLOPT_URL => "https://graph.instagram.com/".$user_id."?fields=id,username,media_count&access_token=".$access_token,
	      CURLOPT_RETURNTRANSFER => true,
	      CURLOPT_ENCODING => "",
	      CURLOPT_MAXREDIRS => 10,
	      CURLOPT_TIMEOUT => 0,
	      CURLOPT_FOLLOWLOCATION => true,
	      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	      CURLOPT_CUSTOMREQUEST => "GET",
	      CURLOPT_HTTPHEADER => array(
	        "Cookie: ig_did=4700D898-5981-473B-A179-2C06BE30B7F5; mid=XoconQAEAAF9bpljM4tGxzZxVYDs; csrftoken=fy0n0sLeusrMupwAnMcmeRCjsMoGNOBe; rur=PRN"
	      ),
	    ));

	    $response = curl_exec($curl);

	    curl_close($curl);

	    $response = json_decode($response);

	    return $response;

	}

	/**
	 * @since 1.0.0
	 * @return array of user media
	 * @param string $access_token
	 */
	public function get_user_media($access_token){

		$curl = curl_init();

	    curl_setopt_array($curl, array(
	      CURLOPT_URL => "https://graph.instagram.com/me/media?fields=id,username,caption,media_type,media_url,permalink,thumbnail_url,timestamp&access_token=".$access_token,
	      CURLOPT_RETURNTRANSFER => true,
	      CURLOPT_ENCODING => "",
	      CURLOPT_MAXREDIRS => 10,
	      CURLOPT_TIMEOUT => 0,
	      CURLOPT_FOLLOWLOCATION => true,
	      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	      CURLOPT_CUSTOMREQUEST => "GET",
	      CURLOPT_HTTPHEADER => array(
	        "Cookie: ig_did=4700D898-5981-473B-A179-2C06BE30B7F5; mid=XoconQAEAAF9bpljM4tGxzZxVYDs; csrftoken=fy0n0sLeusrMupwAnMcmeRCjsMoGNOBe; rur=PRN"
	      ),
	    ));

	    $response = curl_exec($curl);

	    curl_close($curl);

	    $response = json_decode($response);

	    return $response;

	}

	/**
	 * @since 1.0.0
	 * @return array of user media for next and previous
	 * @param string $url
	 */
	public function get_user_media_paging($url){

		//next or previous
		$curl = curl_init();

	    curl_setopt_array($curl, array(
	      CURLOPT_URL => $url,
	      CURLOPT_RETURNTRANSFER => true,
	      CURLOPT_ENCODING => "",
	      CURLOPT_MAXREDIRS => 10,
	      CURLOPT_TIMEOUT => 0,
	      CURLOPT_FOLLOWLOCATION => true,
	      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	      CURLOPT_CUSTOMREQUEST => "GET",
	      CURLOPT_HTTPHEADER => array(
	        "Cookie: ig_did=4700D898-5981-473B-A179-2C06BE30B7F5; mid=XoconQAEAAF9bpljM4tGxzZxVYDs; csrftoken=fy0n0sLeusrMupwAnMcmeRCjsMoGNOBe"
	      ),
	    ));

	    $response = curl_exec($curl);

	    curl_close($curl);
	
	    $response = json_decode($response);

	    return $response;
	}


	public function test(){
		return 'test';
	}

}


//$obj = new InstagramApiClass;

//echo $obj->get_short_lived_access_token('client_id', 'client_secret', 'redirect_uri', 'code');

//echo $obj->get_user_profile('user_id', 'access_token');

//echo $obj->get_user_media('access_token');

//echo $obj->get_user_media_paging('url');

//echo $obj->get_long_lived_access_token('client_secret', 'short_live_access_token');

//echo $obj->refresh_long_lived_access_token('long_live_access_token');