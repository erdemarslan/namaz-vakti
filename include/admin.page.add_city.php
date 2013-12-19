<?php

//NV_SEHIR_ID = 'namazvakti_sehir_ID';
//NV_SEHIR_ADI = 'namazvakti_sehir_ADI';
//NV_OPTION_SEHIRLER = 'namazvakti_sehirler';
 
if( isset($_POST["submit"]) )
{
	if( empty($_POST[NV_SEHIR_ID]) OR !is_numeric($_POST[NV_SEHIR_ID]) )
	{
		$mesaj = '<div id="message" class="error fade"><p>Şehir ID mutlaka sayı olmak zorunda!</p></div>';
	}
	elseif ( empty($_POST[NV_SEHIR_ADI]) )
	{
		$mesaj = '<div id="message" class="error fade"><p>Şehir ADI mutlaka yazılmak zorunda!</p></div>';
	}
	else {
		$sehirler = json_decode(get_option(NV_OPTION_SEHIRLER),TRUE);
		if( array_key_exists( $_POST[NV_SEHIR_ID], $sehirler ) )
		{
			$sehirler[$_POST[NV_SEHIR_ID]] = $_POST[NV_SEHIR_ADI];
			$mesaj = '<div id="message" class="updated fade"><p>Şehir daha önceden kaydedildiği için, sadece güncellendi.</p></div>';
		} else {
			$sehirler[$_POST[NV_SEHIR_ID]] = $_POST[NV_SEHIR_ADI];
			$mesaj = '<div id="message" class="updated fade"><p>Şehir başarıyla kaydedildi.</p></div>';
		}
		update_option(NV_OPTION_SEHIRLER, json_encode($sehirler));
	}
	echo $mesaj;
}
?>
<form method="post" action="">
      <table class="form-table">
          <tr valign="top">
              <th scope="row">Şehir ID<br /><span style="font-size: x-small;">EraLabs üzerinden aldığınız Şehir ID numarası</span></th>
              <td>
              <input size="10" type="number" name="<?php echo NV_SEHIR_ID; ?>" placeholder="Şehir ID" />
              <br />
              Şehir ID numaralarını öğrenmek için <a href="http://api.eralabs.net/namazvakti" target="_blank">http://api.eralabs.net/namazvakti</a> adresini ziyaret ediniz.
              </td>
          </tr>
	  
	  <tr valign="top">
              <th scope="row">Şehir Adı<br /><span style="font-size: x-small;">Şehir Adını yazınız</span></th>
              <td>
              <input size="50" type="text" name="<?php echo NV_SEHIR_ADI; ?>" placeholder="Şehir Adı" />
              <br />
              Şehir adlarını öğrenmek için <a href="http://api.eralabs.net/namazvakti" target="_blank">http://api.eralabs.net/namazvakti</a> adresini ziyaret ediniz.
              </td>
          </tr>
      </table>
      <input type="submit" name="submit" class="button-primary" value="Kaydet" />
  </form>