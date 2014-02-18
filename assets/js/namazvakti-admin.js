var default_sehirler_select_value	= '<option value="0">Lütfen bir şehir/eyalet seçiniz</option>';
var default_ilceler_select_value	= '<option value="0">Lütfen bir ilçe/şehir seçiniz</option>';

function selectCity()
{
	var ulke = jQuery('#ulkeler').val();
	
	// Varsayılanları yükle
	jQuery('#sehirler').html(default_sehirler_select_value);
	jQuery('#ilceler').html(default_ilceler_select_value);
	
	if (ulke != 0)
	{
		jQuery.ajax({
			type:		'POST',
			url:		ajaxurl,
			data:		"action=ajax_action&do=getCities&country=" + ulke,
			//dataType:	"json",
			success: 	function( data ) {
				
				var response = jQuery.parseJSON( data );
				
				if( response.durum == 'basarili' )
				{
					jQuery.each( response.veri, function(i, item) {
						var newOption = jQuery('<option />');
						jQuery('#sehirler').append(newOption);
						
						newOption.val(item.value);
						newOption.html(item.text);
					});
				} else {
					alert('ERROR');
				}
			}
		});
	}
}

function selectLocation()
{
	var ulke = jQuery('#ulkeler').val();
	var sehir = jQuery('#sehirler').val();
	
	jQuery('#ilceler').html(default_ilceler_select_value);
	
	if (ulke == 'TURKIYE')
	{
		jQuery.ajax({
			type:		'POST',
			url:		ajaxurl,
			data:		"action=ajax_action&do=getLocations&city=" + sehir,
			//dataType:	"json",
			success: 	function( data ) {
				
				var response = jQuery.parseJSON( data );
				
				if( response.durum == 'basarili' )
				{
					jQuery.each( response.veri, function(i, item) {
						var newOption = jQuery('<option />');
						jQuery('#ilceler').append(newOption);
						
						newOption.val(item.value);
						newOption.html(item.text);
					});
				} else {
					alert('ERROR');
				}
			}
		});
	}
}