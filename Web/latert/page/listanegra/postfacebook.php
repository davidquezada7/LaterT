<?php
	function postToFb($placa,$mensaje){
		$page_access_token = 'EAAEJlS8SDpgBAEjieQsbE344C34Ssa0FLZAZC7qPZA6GbZC92wnuRMIrS5Fzw0wKGvHZC51kGTeZCtPNlb9ZCwK5sDnnrU92thHgFQyaL5D9itkxlx7s8szdzrldq3fdhCnI8r2fu7sAYZBm5YBsBy5E6CJdS0nhILkDfBafgxdvhQZDZD';
		$page_id = '195190794218369';
		$data['picture'] = "http://www.latert.net/page/listanegra/fotos/".$placa.".jpg";
		$data['link'] = "http://www.latert.net/";
		$data['message'] = $mensaje;
		$data['caption'] = "Llamar al 110";
		$data['description'] = "Se busca";


		$data['access_token'] = $page_access_token;

		$post_url = 'https://graph.facebook.com/'.$page_id.'/feed';

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $post_url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$return = curl_exec($ch);
		echo $return;
		curl_close($ch);	
	}
?>