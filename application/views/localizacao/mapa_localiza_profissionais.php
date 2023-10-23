<style>
    #map {
        height: 500px;
    }
</style>
<script type="application/javascript">
    var secondsToRefresh = 3 * 1000;
    var map;
    var markersArray = [];
    var infowindow;
    var labelIndex = 0;

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'),
        {
            center: {lat: -25.429136, lng: -49.267218},
            zoom: 11
        });
        infowindow = new google.maps.InfoWindow;


        // Try HTML5 geolocation.

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                map.setCenter(pos);
            }, function() {});
        }
        refresh();
    }

    function addUpdateMarker(marker) {
        var markerExists = false;
        for (ii = 0; ii < markersArray.length; ii++) {
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

    function requestScheduleRequest() {
        var f = function() {
            refresh();
        }
        setTimeout(f, secondsToRefresh);
    }

    function refresh() {
        $.ajax({
            url: 'localizacao_motoboy/get_motoboys_location_json',
            type: "POST",
            dataType: "json",
            beforeSend: function(xhr) {},
            success: function(data) {
                if (data.error == false) {
                    locations = JSON.parse(data.locations);
                    for (i = 0; i < locations.length; i++) {
                        var position = {
                            lat: Number(locations[i]["latitude"]),
                            lng: Number(locations[i]["longitude"])
                        };
                        var info = '<b>' + locations[i]["nome"] + '</b>';

                        console.log('Info: ' + info);
                        var image = '../img/icons/ic_motorcycle_black_18dp2.png';
                        var marker = new google.maps.Marker({
                            label: locations[i]["idUsuario"],
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
                        if (i == locations.length - 1) {
                            requestScheduleRequest();
                        }
                    }
                } else {
                    console.log('erro');
                    $("#title").html('<span style="color:red">Problemas ao receber localização. Atualize o navegador!</span>');
                }
            },
            error: function(request, error) {
                $("#title").html('<span style="color:red">Problemas ao requisitar localização. Atualize o navegador!</span>');
            }
        });
    }

    function request_location() {
        $.ajax({
            url: 'localizacao_motoboy/send_location_request',
            beforeSend: function(xhr) {
                $('#sub-title').append(htmlGifCarregando());
            },
            success: function(data) {
                $('#sub-title').html('');
            },
            error: function(request, error) {
                $("#sub-title").html('<span style="color:red">Problemas ao requisitar atualização.</span>');
            }
        });
    }
    $(document).ready(function() {
        request_location();
    })

</script>
    <div class="row-fluid" style="margin-top:-30px">
        <div class="span12">
            <div class="widget-content">
                <fieldset>
                    <legend class="form-title" style="margin-bottom:0 !important">
                        <i class="icon-list-alt icon-title"></i>Mapa e Localização
                    </legend>
                    <div class="span12" id="divatraso" style=" margin-left: 0">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab1">
                                <div class="widget-box" style="border-bottom: 1px solid #CDCDCD;">
                                    <div class="widget-title">
                                        <h5>&raquo; Mapa de localização dos profissionais</h5>
                                    </div>
                                    <div style="padding: 10px;">
                                        <div id="title" style="color: #0b84fe">Exibindo a localização</div>
                                        <div id="sub-title" style="color: #0b84fe">Enviando requisição de atualização</div>
                                        <div id="map"></div>
                                        <div class="map-info" style="margin-top: 30px;">Exibe a localização dos profissionais com status online no aplicativo, com localização recuperada nas ultimas 6 horas.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
    </div>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAfagobKAjkLtWO6ONwkMMP6OVF0BMJPYg&language=pt-BR&callback=initMap"></script>