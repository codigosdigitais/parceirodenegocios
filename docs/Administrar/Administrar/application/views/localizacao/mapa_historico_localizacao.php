<style type="text/css">
	#map {
	    height: 500px;
	}
</style>
<script type="application/javascript">
/*    var map;
	var markersArray = [];
	var infowindow;

	function initMap() {
	    map = new google.maps.Map(document.getElementById('map'),
        {
            center: {lat: -25.429136, lng: -49.267218},
            zoom: 11
        });
        infowindow = new google.maps.InfoWindow;


		/if (navigator.geolocation) {
		    navigator.geolocation.getCurrentPosition(function(position) {
		        var pos = {
		            lat: position.coords.latitude,
		            lng: position.coords.longitude
		        };
		        map.setCenter(pos);
		    }, function() {});
		}
	}

	function addUpdateMarker(marker) {
	    var markerExists = false;
	    for (var ii = 0; ii < markersArray.length; ii++) {
	        if (markersArray[ii].info == marker.info) {
	            markerExists = true;
	            markersArray[ii].setPosition(marker.getPosition());
	        }
	    }
	    if (!markerExists) {
	        marker.setMap(map);
	        markersArray.push(marker);
	    }
	}

	function loadHistory() {
	    if ($('#profissional').val() == '') {
	        $("#title").html('<span style="color:red">Selecione um profissional!</span>');
	        return;
	    }
	    $.ajax({
	        url: 'localizacao_motoboy_historico/get_motoboys_location_history_json',
	        type: "POST",
	        data: {
	            idProfissional: $('#profissional').val(),
	            dataInicio: $('#dataInicio').val(),
	            dataFim: $('#dataFim').val(),
	            offset: $('#offset').val()
	        },
	        dataType: "json",
	        beforeSend: function(xhr) {
	            $("#title").html('Buscando registros...');
	        },
	        success: function(data) {
	            if (data.error == false) {
	                console.log(data);
	                locations = JSON.parse(data.locations);
	                if (locations.length == 0) {
	                    $("#title").html('<span style="color:red">Nenhum histórico foi encontrado para os filtros selecionados!</span>');
	                    return;
	                }
	                $("#title").html('Selecione os registros que deseja exibir');
	                $('#locations').html('');
	                for (i = 0; i <locations.length; i++) {
	                    var option = "<option " + "value='" + locations[i]['id'] + "' " + "data-latitude='" + locations[i]['latitude'] + "' " + "data-longitude='" + locations[i]['longitude'] + "'>" + locations[i]['updated_at'] + "</option>";
	                    $('#locations').append(option);
	                }
	                if (data.maxRecordsAchieved != false) {
	                    $('#offset').css('border', '1px solid red');
	                    var curOffset = Number($('#offset').val());
	                    var totalPages = Math.ceil(data.totalRecords / data.maxRecordsAchieved);
	                    $('#offset').html('');
	                    for (i = 0; i <totalPages; i++) {
	                        var option = "<option value='" + i + "' ";
	                        if (i == curOffset) {
	                            option += 'selected';
	                        }
	                        option += ">" + (i + 1) + "</option>";
	                        $('#offset').append(option);
	                    }
	                } else {
	                    $('#offset').css('border', '');
	                    $('#offset option:gt(0)').remove();
	                }
	            } else {
	                $("#title").html('<span style="color:red">Problemas ao receber localização. Atualize o navegador!</span>');
	            }
	        },
	        error: function(request, error) {
	            $("#title").html('<span style="color:red">Problemas ao requisitar localização. Atualize o navegador!</span>');
	        }
	    });
	}

	function updateMapMarkers(latitude, longitude, info) {
	    var position = {
	        lat: latitude,
	        lng: longitude
	    };
	    var info = '<b>' + info + '</b>';
	    var image = '../img/icons/ic_map_point_blue.png';
	    var marker = new google.maps.Marker({
	        position: position,
	        info: info,
	        animation: google.maps.Animation.DROP,
	        icon: image
	    });
	    marker.addListener('click', function() {
	        infowindow.setContent(this.info);
	        infowindow.open(map, this);
	    });
	    addUpdateMarker(marker);
	}

    $(document).ready(function() {
	    $('#profissional, #dataInicio, #dataFim').change(function() {
	        $('#offset option:gt(0)').remove();
	    });
	    $('#locations').change(function() {
	        for (var i = 0; i < markersArray.length; i++) {
	            markersArray[i].setMap(null);
	        }
	        markersArray = [];
	        $('#locations option:selected').each(function() {
	            updateMapMarkers(Number($(this).attr('data-latitude')), Number($(this).attr('data-longitude')), $('#profissional option:selected').text() + "<br>" + $(this).text() + "<br>Lat: " + $(this).attr('data-latitude') + "<br>Lon: " + $(this).attr('data-longitude'));
	        });
	    });
	});*/
</script>

<div class="row-fluid" style="margin-top:-30px">
	<div class="span12">
		<div class="widget-content">
			<fieldset>
				<legend class="form-title" style="margin-bottom:0 !important">
					<i class="icon-list-alt icon-title"> </i> Histórico de Localização
				</legend>
				<div class="span12" id="divatraso" style=" margin-left: 0">
					<div class="tab-content">
						<div class="tab-pane active" id="tab1">
							<div class="widget-box" style="border-bottom: 1px solid #CDCDCD;height: 160px">
								<div class="widget-title">
									<h5> &raquo;Mapa de localização dos profissionais </h5>
								</div>
								<div style="padding: 10px;">
									Filtros:
									<div style="padding: 10px;">
										<div class="span3">
											<label for="profissional"> Profissional: </label>
											<select id="profissional" name="profissional" autofocus>
												<option value="">Escolha o profissional</option>
												<?php
												foreach($profissionais AS $profissional) {
													echo '<option value="'.$profissional->idUsuario.'">'. $profissional->nome .'</option>';
												}?>
											</select>
										</div>
										<div class="span2">
											<label for="dataInicio"> Data Inicial: </label>
											<input type="date" id="dataInicio" name="dataInicio" class="input-medium" value="<?= date('Y-m-d', strtotime(date('Y-m-d') . " -30 days ")) ?>"/>
										</div>
										<div class="span2">
											<label for="dataFim">Data Final:</label>
											<input type="date" id="dataFim" name="dataFim" class="input-medium" value="<?= date('Y-m-d') ?>" />
										</div>
										<div class="span2">
											<label for="dataFim">Página</label>
											<select id="offset" class="input-small">
												<option value="0"> 1 </option>
											</select>
										</div>
										<div class="span2" style="padding-top: 25px">
											<button type="button" id="filtrar" onclick="loadHistory()">Filtrar</button>
										</div>
									</div>
								</div>
							</div>
							<div class="span3" style="margin-left:0">
								<div> Localizações: </div>
								<div>
									<select id="locations" style="width: 100%;height: 500px" multiple> </select>
								</div>
							</div>
							<div class="span9" style="float: right;">
								<div id="title" style="color: #0b84fe"></div>


    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTj0bjNQCYqIXr68J4tJxIRpNBvkFM8gw&callback=initMap&libraries=&v=weekly"
      defer
    ></script>

    <div id="map"></div>



								<div class="map-info" style="margin-top: 30px;">
									Exibe a localização dos profissionais com status online no aplicativo, com localização recuperada nas ultimas 6 horas.
								</div>
							</div>
						</div>
					</div>
				</div>
			</fieldset>
		</div>
	</div>
</div>



