import algoliasearch from 'algoliasearch/lite';
import cache from './cache';
import throttle from './throttle';
(function () {
    document.querySelector('input#query').onkeyup = throttle(async (event) => {
        const q = event.target.value;
        if (q.length < 2) {
            return
        }
        const res = await search(q);
        showResults(res);
    }, 500);

    async function search(query) {
        let key;
        let id;

        if (await cache.get('algolia_search_key_only') === null) {
            console.log('here');
            const res = await fetch('/key');
            const r = await res.json();
            key = r.key;
            id = r.id;
            cache.set('algolia_search_key_only', key);
            cache.set('id', id);
        } else {
            key = await cache.get('algolia_search_key_only');
            id = await cache.get('id')
        }

        const requestOptions = {

        }
        const client = algoliasearch(id, key);
        const index = client.initIndex('dev_products');
        const results = await index.search(query, requestOptions);
        return results;
    }


    const showResults = results => {
        let search = '';
        results.hits.forEach(hit => {
            search = search + unit(hit);
        });
        document.querySelector('h3#count').innerHTML = `${results.nbHits} Results for "${results.query}"`;
        document.querySelector('div#results').innerHTML = search;
    }

    const unit = hit => (`
        <div class="border-bottom">
            <strong>
                ${hit._highlightResult.name.value}
                --
                <b>
                    ${hit.price} $
                </b>
            </strong>
            <p>
                ${hit._highlightResult.description.value}
            </p>
        </div>
    `);

})()