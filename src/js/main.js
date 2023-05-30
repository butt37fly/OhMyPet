/**
 * Oculta la capa del loading y ejecuta las funciones generales del body
*/
function Init(){
  const Body = document.querySelector( 'body' );
  let time = 100;
  
  setTimeout( () => {
    Body.classList.add( 'ready' );
    BodyFunctions();
  }, time);
}

Init();

/***************************************/

/**
 * Condiciona e inicializa las funciones del sitio
 */
function BodyFunctions(){
  if( document.querySelector('.Card') ){
    Products();
  }
}

/**
 * Controla toda la interactividad relacionada con los productos
 */
function Products(){
  const Cards = document.querySelectorAll('.Card');
  if ( !Cards || !Cards.length > 0 ) return;

  /**
   * Efecto de rotación de las cards
   * 
   * @param {HTMLElement} card Elemento (Producto) con la clase `.Card`  
   */
  function handleCardSide( card ){
    const updateClass = (el) => {
      el.classList.toggle('Card--active');
    }

    let front = card.querySelector( '.Card__front' );
    let button = card.querySelector( '.Card__back .Button--back' );
  
    front.addEventListener( 'click', () => updateClass(card) );
    button.addEventListener( 'click', () => updateClass(card) );
  }

  /**
   * Funcionamiento del botón para modificar la cantidad
   * 
   * @param {HTMLElement} card Elemento (Producto) con la clase `.Card`  
   */
  function addToCart( card ){
    const form = card.querySelector('.Cart');
    if ( !form ) return;

    const qtyButton = form.querySelector( '.Qty' );
    const units = form.querySelector( 'input[name="units"]' );
    const max = form.querySelector( 'input[name="max"]' );

    const handleUnits = ( qty, unitsInput, max ) => {
      max = parseInt(max.value);
      const button = {
        display : qty.querySelector('.Qty__display'),
        addButton : qty.querySelector('.Qty__button--add'),
        removeButton : qty.querySelector('.Qty__button--remove')
      }
      
      const updateUnits = (newValue) => {
        unitsInput.value = newValue;
        button.display.textContent = newValue;
      }

      const addUnits = () => {
        let units = parseInt(unitsInput.value);
        if( units === max ) return;
        units = units + 1;
        updateUnits(units);
      }
      
      const removeUnits = () => {
        let units = parseInt(unitsInput.value);
        if( units === 0 ) return;
        units = units - 1;
        updateUnits(units);
      }

      button.addButton.addEventListener( 'click', addUnits );
      button.removeButton.addEventListener( 'click', removeUnits );
    }

    handleUnits(qtyButton, units, max);
  }

  Cards.forEach( (card) => {
    handleCardSide( card );
    addToCart( card );
  });
}

