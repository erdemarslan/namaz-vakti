<?php

//NV_OPTION_API_ANAHTARI = 'namazvakti_api_anahtari';
 
if(isset($_POST["submit"])){
	
	$anahtar = $_POST[ NV_OPTION_API_ANAHTARI ];
	update_option( NV_OPTION_API_ANAHTARI, $anahtar );
	
	$anahtar_goster = $anahtar;
    echo '<div id="message" class="updated fade"><p>Ayarlar başarıyla kaydedildi.</p></div>';
}
else{
    $anahtar_goster = get_option( NV_OPTION_API_ANAHTARI );
}
?>
<form method="post" action="">
	<?php //wp_nonce_field( 'namazvakti_admin_general_options' ); ?>
      <table class="form-table">
          <tr valign="top">
              <th scope="row">API ANAHTARI<br /><span style="font-size: x-small;">EraLabs üzerinden aldığınız API anahtarı</span></th>
              <td>
              <input size="50" type="text" name="<?php echo NV_OPTION_API_ANAHTARI; ?>" placeholder="API Anahtarınızı Giriniz" value="<?php echo htmlspecialchars( $anahtar_goster ); ?>" />
              <br />
              API anahtarı almak için <a href="http://api.eralabs.net/api-anahtari" target="_blank">http://api.eralabs.net/api-anahtari</a> adresini ziyaret ediniz.
              </td>
          </tr>
      </table>
      <input type="submit" name="submit" class="button-primary" value="Kaydet" />
  </form>