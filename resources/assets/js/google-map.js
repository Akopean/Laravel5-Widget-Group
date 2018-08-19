"use strict";

window.jQuery = require('jquery');

/**
 * Google Map Class
 */
export default class GoogleMap {

    /**
     */
    constructor(elements, options) {
        this.$key = options.key;
        this.$markers = null;
        this.options = {
            zoom: options.zoom,
            center: options.center,
            //    mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        let els = $(elements).filter(function (i, e) {
            return !$(e).parents('#left').length;
        });
        this.initGoogleJs();
        this.$element = $(els);
    }

    initGoogleJs() {
        if (!$('#gmaps-api').length) {

            window.renderMap = this.renderMap.bind(this);
            var s = document.createElement('script');
            s.src = 'https://maps.googleapis.com/maps/api/js?key=' + this.$key + '&callback=renderMap';
            s.type = 'text/javascript';
            s.id = 'gmaps-api';
            s.async = true;
            s.defer = true;
            $('script:last').before(s);
        }
    };

    renderMap() {
        this.$element.map((index, element) => {
            this.createMap(element)
        });
    };

    /* addMarker(map, infowindow, props) {
     let marker = new google.maps.Marker({
     position: props.coords,
     map: map,
     });
     //check icon image
     if (props.iconImage) {
     marker.setIcon(props.iconImage);
     }
     //check content
     if (props.content) {
     const infoWindow = new google.maps.InfoWindow({
     content: props.content
     });
     marker.addListener('click', () => {
     infoWindow.open(map, marker);
     });
     }

     };*/

    static geocodeLatLng(map, geocoder, infowindow, google_markers, options) {
        this.deleteMarkers(google_markers, options.el);
        geocoder.geocode({'location': {lat: options.lat, lng: options.lng}}, function (results, status) {
            if (status === 'OK') {
                if (results[0]) {
                    map.setZoom(11);
                    const marker = new google.maps.Marker({
                        position: {lat: options.lat, lng: options.lng},
                        map: map
                    });
                    google_markers[0] = marker;
                    infowindow.setContent(results[0].formatted_address);
                    infowindow.open(map, marker);
                    $(options.el).prev().find('[data-googleMapTitle="google"]').val(results[0].formatted_address);
                    $(options.el).prev().find('[data-cord="google"]').val(JSON.stringify({
                        lat: options.lat,
                        lng: options.lng
                    }));
                } else {
                    window.alert('No results found');
                }
            } else {
                window.alert('Geocoder failed due to: ' + status);
            }
        });
    };

    // Deletes all markers in the array by removing references to them.
    static deleteMarkers(google_markers, el) {
        if (google_markers.length) {
            google_markers[0].setMap(null);
            google_markers = [];
            $(el).prev().find('[data-googleMapTitle="google"]').val('');
            $(el).prev().find('[data-cord="google"]').val('');
        }
    };

    createMap(el) {
        const map = new google.maps.Map(el, this.options);
        const geocoder = new google.maps.Geocoder;
        const infowindow = new google.maps.InfoWindow;
        const google_markers = [];
        let cord = $(el).prev().find('[data-cord="google"]').val();

        if (cord.length) {
            let location = JSON.parse(cord);
            GoogleMap.geocodeLatLng(map, geocoder, infowindow, google_markers, {
                el: el,
                lat: location.lat,
                lng: location.lng
            });
        }
        google.maps.event.addListener(map, 'click', function (e) {
            GoogleMap.geocodeLatLng(map, geocoder, infowindow, google_markers, {
                el: el,
                lat: e.latLng.lat(),
                lng: e.latLng.lng()
            });
            google.maps.event.addListener(map, "rightclick", function() {

                GoogleMap.deleteMarkers(google_markers, el);
            });
        });
    };
};
