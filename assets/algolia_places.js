import places from 'places.js';

function placesAutoComplete() {
    const div = document.querySelector('div#data');
    if (!div) {
        return;
    }
    const appId = div.dataset.id;
    const apiKey = div.dataset.key;
    const container = document.querySelector('#address-input');

    const fixedOptions = {
        appId,
        apiKey,
        container,
    };

    const reconfigurableOptions = {
        language: 'fr', // Receives results in German
        countries: ['ma', 'fr'], // Search in the United States of America and in the Russian Federation
        type: 'city', // Search only for cities names
        aroundLatLngViaIP: false // disable the extra search/boost around the source IP
    };

    places(fixedOptions).configure(reconfigurableOptions);
}

placesAutoComplete();