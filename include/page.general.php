<?php if( !defined('NV_NAME') ) die('You can not access this file directly!');

if (isset($_POST['submit']))
{
	$ulke = $_POST['ulkeler'];
	$sehir = $_POST['sehirler'];
	$ilce = $_POST['ilceler'];

	if( $ulke != "0" OR $sehir != "0" )
	{
		// kaydetmeye başlayabiliriz!
		if( $ulke == 2 || $ulke == 33 || $ulke == 52 || $ulke == 13 || $ulke == 42 || $ulke == 47 || $ulke == 64 ) {
			if($ilce == 0) {
				echo '<div id="message" class="updated fade"><p>';
				_e('Lütfen tüm alanları doldurunuz!', 'namazvakti');
				echo '</p></div>';
			} else {
				update_option( NV_DB_DEFAULT_COUNTRY_NAME, $ulke );
				update_option( NV_DB_DEFAULT_CITY_NAME, $sehir );
				update_option( NV_DB_DEFAULT_TOWN_NAME, $ilce );
				
				echo '<div id="message" class="updated fade"><p>';
				_e('Ayarlar başarıyla kaydedildi.', 'namazvakti');
				echo '</p></div>';
			}
		} else {
			update_option( NV_DB_DEFAULT_COUNTRY_NAME, $ulke );
			update_option( NV_DB_DEFAULT_CITY_NAME, $sehir );
			update_option( NV_DB_DEFAULT_TOWN_NAME, $sehir );
			
			echo '<div id="message" class="updated fade"><p>';
			_e('Ayarlar başarıyla kaydedildi.', 'namazvakti');
			echo '</p></div>';
		}
	} else {
		echo '<div id="message" class="updated fade"><p>';
		_e('Lütfen tüm alanları doldurunuz!', 'namazvakti');
		echo '</p></div>';
	}
}

$varsayilan_ulke	= get_option( NV_DB_DEFAULT_COUNTRY_NAME );
$varsayilan_sehir	= get_option( NV_DB_DEFAULT_CITY_NAME );
$varsayilan_ilce	= get_option( NV_DB_DEFAULT_TOWN_NAME );

$disabled = "";
if( $varsayilan_ulke == 2 || $varsayilan_ulke == 33 || $varsayilan_ulke == 52 || $varsayilan_ulke == 13 || $varsayilan_ulke == 42 || $varsayilan_ulke == 47 || $varsayilan_ulke == 64 ) {
	$disabled = '';
} else {
	$disabled = ' disabled = "disabled"';
}

?>

<form method="post" action="">
<table class="form-table">
    
    <tr valign="top" id="ulkeler_alani">
    	<th scope="row"><?php _e('Varsayılan Ülke', 'namazvakti'); ?></th>
        
        <td>
        	<select name="ulkeler" id="ulkeler" onChange="selectCity();">
            	<option value="0"><?php _e('Lütfen bir ülke seçiniz', 'namazvakti'); ?></option>
                <?php
					$page_ulkeler = $this->nv->ulkeler();
					foreach ($page_ulkeler['veri'] as $id => $ulke)
					{
						$selected = $varsayilan_ulke == $id ? ' selected' : '';
						echo '<option value="' . $id . '" ' . $selected . '>' . __($ulke, 'namazvakti') . '</option>';
					}
				?>
            </select>
		</td>
    </tr>
    
    
    <tr valign="top" id="sehirler_alani">
    	<th scope="row"><?php _e('Varsayılan Şehir', 'namazvakti'); ?></th>
        
        <td>
        	<select name="sehirler" id="sehirler" onChange="selectLocation();">
            	<option value="0"><?php _e('Lütfen bir şehir seçiniz', 'namazvakti'); ?></option>
                <?php
					$page_sehirler = $this->nv->sehirler( $varsayilan_ulke );
					foreach( $page_sehirler['veri'] as $key => $value )
					{
						$selectedsehir = $varsayilan_sehir == $key ? ' selected' : '';
						echo '<option value="' . $key . '" ' . $selectedsehir . '>' . $value . '</option>';
					}
				?>
            </select>            
		</td>
    </tr>
    
    
    
    <tr valign="top" id="ilceler_alani">
    	<th scope="row"><?php _e('Varsayılan İlçe', 'namazvakti'); ?></th>
        
        <td>
        	<select name="ilceler" id="ilceler"<?php echo $disabled; ?>>
            	<option value="0"><?php _e('Lütfen bir ilçe seçiniz', 'namazvakti'); ?></option>
                <?php
					if( $varsayilan_ulke == 2 || $varsayilan_ulke == 33 || $varsayilan_ulke == 52 || $varsayilan_ulke == 13 || $varsayilan_ulke == 42 || $varsayilan_ulke == 47 || $varsayilan_ulke == 64 )
					{
						$page_ilceler = $this->nv->ilceler( $varsayilan_ulke, $varsayilan_sehir );
						foreach ( $page_ilceler['veri'] as $key => $value )
						{
							$selectedilce = $varsayilan_ilce == $key ? ' selected' : '';
							echo '<option value="' . $key . '"' . $selectedilce . '>' . $value . '</option>';
						}
					}
				?>
            </select><br>
            <?php _e('Sadece; Ülke, TÜRKİYE seçilmiş ise İlçeler listesi aktif olur. Onun dışında bu liste boş olacaktır.', 'namazvakti'); ?>
            
		</td>
    </tr>
    
    
    
    
</table>

<input type="submit" name="submit" class="button-primary" value="<?php _e('Kaydet', 'namazvakti'); ?>" />

</form>