//const api_key1 = "447038df7003d21b79e110e925a8568d";
//const request1 = 'http://api.mediastack.com/v1/news?languages=it&keywords=palestra-palestre-Catania-Covid&limit=21&access_key=' + api_key1;

//const api_key2 = '21218063-0071ff8a98ffb5ef1f88d9110';
//const api_endpoint = 'https://pixabay.com/api/';
//const text = "workout";
//const numResults = 100;
//const request2 = api_endpoint + '?key='  + api_key2 + '&q=' + text + '&per_page=' + numResults;



function onResponse(response){
	return response.json();
}

function onJson(json){

	let articoli = document.querySelector('#news');
	articoli.innerHTML = '';

	for (let i = 0; i < 21; i++)
    {

        let titolo = document.createElement('h1');
        let link= document.createElement('a');

        titolo.textContent = json.data[i].title;
        link.textContent = '- Visita il sito -';
        link.addEventListener('click',function(){
            window.open(json.data[i].url);
            fetch("http://localhost/Sito/aggiungi_news.php?q="+ json.data[i].url+"&t="+json.data[i].title);
        });



        const articolo = document.createElement('div');
        articolo.id=i;


        articolo.appendChild(link);
        articolo.appendChild(titolo);
        articoli.appendChild(articolo);
    }

}

//fetch(request1).then(onResponse).then(onJson);
fetch('http://localhost/Sito/api_news.php').then(onResponse).then(onJson);


// ----------------------------------------------------------------------------------------------- //

function riduciZoom(event) {
	if(event.key === 'Escape')
	{
		zoom.classList.add('hidden');
		img = zoom.querySelector('img');
		img.remove();
		document.body.classList.remove('no-scroll');
	}
}

window.addEventListener('keydown', riduciZoom);

function applicaZoom(event) {
	const image = document.createElement('img');
	image.src = event.currentTarget.src;
	zoom.appendChild(image);
	zoom.classList.remove('hidden');
	document.body.classList.add('no-scroll');
}

function onJson2(json) {
    const atleti = document.querySelector('#atleti');
    atleti.innerHTML = '';
    const results = json.hits
    console.log(json);

    for(result of results)
    { 

        if(result.id === 2604149 || result.id === 828726 || result.id === 1282232 || 
            result.id === 1850926  || result.id === 4329901)
        {

        const immagine = result.largeImageURL;
  
      const album = document.createElement('div');
      album.classList.add('imag');
      const img = document.createElement('img');
      img.src = immagine;

      img.addEventListener('click', applicaZoom);

         
      album.appendChild(img);
    
      atleti.appendChild(album);
        }
    }
}

function onResponse2(response) {
    return response.json();
}


fetch('http://localhost/Sito/api_immagini.php').then(onResponse2).then(onJson2);


  /*----------------------------------------------------------------------------------------------------------------------------------*/

  function onJson3(json) {
    const nuove_affiliazioni = document.querySelector('#nuove_affiliazioni');
    console.log(json);

    for(let i=0; i<json.length; i++)
    { 

  
      const album = document.createElement('div');
      album.classList.add('imag');
      const img = document.createElement('img');
      img.src = json[i].indirizzo;

      img.addEventListener('click', applicaZoom);
      
      const descrizione = document.createElement('p');
      descrizione.classList.add('descrizione');
      descrizione.textContent = json[i].nome;

         
      album.appendChild(img);
      album.appendChild(descrizione);
      
      nuove_affiliazioni.appendChild(album);
        
    }
}

function onResponse3(response) {
    return response.json();
}

fetch('http://localhost/Sito/carica_nuove_aperture.php').then(onResponse3).then(onJson3);