<?php

//NV_OPTION_SEHIRLER = 'namazvakti_sehirler';
//NV_OPTION_VARSAYILAN_SEHIR = 'namazvakti_varsayilan_sehir';
$veritabanindaki_sehirler = json_decode( get_option( NV_OPTION_SEHIRLER ), TRUE );
$varsayilan_sehir = get_option( NV_OPTION_VARSAYILAN_SEHIR );


if( isset($_POST['submit']) )
{
	$post = $_POST;
	unset($post['submit']);
	
	if (count($post) > 0)
	{
		foreach($post as $k=>$v)
		{
			$id = explode('sehir_',$k);
			unset($veritabanindaki_sehirler[$id[1]]);
		}
		update_option( NV_OPTION_SEHIRLER, json_encode($veritabanindaki_sehirler) );
		echo '<div id="message" class="updated fade"><p>Seçilen şehirler başarıyla veritabanından silindi.</p></div>';
	} else {
		echo '<div id="message" class="error fade"><p>Silmek için şehir seçilmedi!</p></div>';
	}
}

if( isset( $_POST['submit2'] ) )
{
	if ( isset($_POST['varsayilan']) )
	{
		$varsayilan = $_POST['varsayilan'];
		update_option( NV_OPTION_VARSAYILAN_SEHIR, $varsayilan);
		echo '<div id="message" class="updated fade"><p>Varsayılan şehir değiştirildi.</p></div>';
		$varsayilan_sehir = $varsayilan;
		
	} else {
		echo '<div id="message" class="error fade"><p>Seçim yapmadığınız için varsayılan şehir ile ilgili işlem yapılmadı!</p></div>';
	}
}


?>
<style>.tablo_satiri:hover{ background-color: #eeeeee;	}</style>
<form method="post" action="">
	<input type="submit" name="submit2" class="button-primary" value="Varsayılanı Kaydet" />
	<input type="submit" name="submit" class="button-primary" value="Seçili olanları Sil" />
	<br><br>
	<table class="widefat" style="width: 60%;">
	<thead>
	    <tr>
		<th style="width: 10%;"><strong>Şehir ID</strong></th>
		<th style="width: 70%;"><strong>Şehir ADI</strong></th>
		<th style="width: 10%;"><strong>Varsayılan</strong></th>
		<th style="width: 10%;"><strong>Sil?</strong></th>
	    </tr>
	</thead>
	
	<tbody>
	<?php foreach ($veritabanindaki_sehirler as $id=>$adi)
	{
		$checked = $varsayilan_sehir == $id ? ' checked' : '';
	?>
	   <tr class="tablo_satiri">
	     <td><?php echo $id; ?></td>
	     <td><?php echo $adi; ?></td>
	     <td style="text-align: center;"><input type="radio"<?php echo $checked; ?> name="varsayilan" value="<?php echo $id; ?>"></td>
	     <td><input type="checkbox" name="sehir_<?php echo $id; ?>"></td>
	   </tr>
	<?php
	}
	?>
	</tbody>
	</table><br>
	<input type="submit" name="submit2" class="button-primary" value="Varsayılanı Kaydet" />
	<input type="submit" name="submit" class="button-primary" value="Seçili olanları Sil" />
	
</form>