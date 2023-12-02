document.addEventListener( 'DOMContentLoaded', function () {
    var main = new Splide( '#main-carousel', {
      rewind    : true,
      pagination: false,
      arrows    : false,
    } );
  
    var thumbnails = new Splide( '#thumbnail-carousel', {
      fixedWidth  : 100,
      fixedHeight : 60,
      gap         : 10,
      rewind      : true,
      pagination  : false,
      arrows    : false,
      isNavigation: true,
    } );
  
    main.sync( thumbnails );
    main.mount();
    thumbnails.mount();
  } );