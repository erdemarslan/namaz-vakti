<?php

//NV_OPTION_API_ANAHTARI = 'namazvakti_api_anahtari';
 
if(isset($_POST["submit"])){
	
	$anahtar = $_POST[ NV_OPTION_API_ANAHTARI ];
	update_option( NV_OPTION_API_ANAHTARI, $anahtar );
	
	$color = $_POST[ NV_OPTION_WIDGET_RENGI ];
	update_option( NV_OPTION_WIDGET_RENGI, $color );
	
	$anahtar_goster = $anahtar;
	$wcolor = $color;
	
    echo '<div id="message" class="updated fade"><p>Ayarlar başarıyla kaydedildi.</p></div>';
}
else{
    $anahtar_goster = get_option( NV_OPTION_API_ANAHTARI );
    $wcolor = get_option( NV_OPTION_WIDGET_RENGI );
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
	  
	  <tr valign="top">
              <th scope="row">WIDGET RENGİ<br /><span style="font-size: x-small;">Sitenizde görünecek widgetin rengini belirler</span></th>
              <td>
		<select style="width: 200px;" name="<?php echo NV_OPTION_WIDGET_RENGI; ?>">
			<option value="yesil" <?php if($wcolor=="yesil") { echo 'selected'; } ?>>Yeşil</option>
			<option value="mavi" <?php if($wcolor=="mavi") { echo 'selected'; } ?>>Mavi</option>
			<option value="kirmizi" <?php if($wcolor=="kirmizi") { echo 'selected'; } ?>>Kırmızı</option>
			<option value="turuncu" <?php if($wcolor=="turuncu") { echo 'selected'; } ?>>Turuncu</option>
			<option value="siyah" <?php if($wcolor=="siyah") { echo 'selected'; } ?>>Siyah</option>
		</select>
              <br />
              Bu değeri değiştirdiğinizde Widget'inizin zemin rengi değişir.
              </td>
          </tr>
      </table>
      <input type="submit" name="submit" class="button-primary" value="Kaydet" />
  </form>