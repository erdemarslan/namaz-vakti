<?php if( !defined('NV_NAME') ) die('You can not access this file directly!');

if (isset($_POST['submit']))
{
	if( $_POST['ulkeler'] != "0" OR $_POST['sehirler'] != "0" )
	{
		// kaydetmeye başlayabiliriz!
		$sehir = $_POST['ilceler'] == "0" ? $_POST['sehirler'] : $_POST['ilceler'];
		
		update_option( NV_DB_DEFAULT_COUNTRY_NAME, $_POST['ulkeler'] );
		update_option( NV_DB_DEFAULT_CITY_NAME, $_POST['sehirler'] );
		update_option( NV_DB_DEFAULT_TOWN_NAME, $sehir );
		
		echo '<div id="message" class="updated fade"><p>';
		_e('Ayarlar başarıyla kaydedildi.', 'namazvakti');
		echo '</p></div>';
	}
}
$varsayilan_ulke	= get_option( NV_DB_DEFAULT_COUNTRY_NAME );
$varsayilan_sehir	= get_option( NV_DB_DEFAULT_CITY_NAME );
$varsayilan_ilce	= get_option( NV_DB_DEFAULT_TOWN_NAME );
?>

<form method="post" action="">
<table class="form-table">
    
    <tr valign="top" id="ulkeler_alani">
    	<th scope="row"><?php _e('Varsayılan Ülke', 'namazvakti'); ?></th>
        
        <td>
        	<select name="ulkeler" id="ulkeler" onChange="selectCity();">
            	<option value="0"><?php _e('Lütfen bir ülke seçiniz', 'namazvakti'); ?></option>
                <option value="TURKIYE" <?php if($varsayilan_ulke == 'TURKIYE') { echo 'selected'; } ?>><?php _e('TURKIYE', 'namazvakti'); ?></option>
                <?php
					$page_ulkeler = $this->nv->ulkeler();
					foreach ($page_ulkeler as $value => $text)
					{
						$selected = $varsayilan_ulke == $value ? ' selected' : '';
						if($value != 'TURKIYE')
						{
							echo '<option value="' . $value . '" ' . $selected . '>' . __($value, 'namazvakti') . '</option>';
						}
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
					foreach( $page_sehirler['veri'] as $ps )
					{
						$selectedsehir = $varsayilan_sehir == trim($ps['value']) ? ' selected' : '';
						echo '<option value="' . trim($ps['value']) . '" ' . $selectedsehir . '>' . $ps['text'] . '</option>';
					}
				?>
            </select>            
		</td>
    </tr>
    
    
    
    <tr valign="top" id="ilceler_alani">
    	<th scope="row"><?php _e('Varsayılan İlçe', 'namazvakti'); ?></th>
        
        <td>
        	<select name="ilceler" id="ilceler">
            	<option value="0"><?php _e('Lütfen bir ilçe seçiniz', 'namazvakti'); ?></option>
                <?php
					if( $varsayilan_ulke == 'TURKIYE' )
					{
						$page_ilceler = $this->nv->ilceler( $varsayilan_sehir );
						foreach ( $page_ilceler['veri'] as $pi )
						{
							$selectedilce = $varsayilan_ilce == trim($pi['value']) ? ' selected' : '';
							echo '<option value="' . trim($pi['value']) . '"' . $selectedilce . '>' . $pi['text'] . '</option>';
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