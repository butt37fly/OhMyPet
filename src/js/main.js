/**
 * Oculta la capa del loading y ejecuta las funciones generales del body
 */
function Init() {
  const Body = document.querySelector("body");
  let time = 100;

  setTimeout(() => {
    Body.classList.add("ready");
    BodyFunctions();
  }, time);
}

Init();

/***************************************/

/**
 * Condiciona e inicializa las funciones del sitio
 */
function BodyFunctions() {
  if(document.querySelector(".Card")) {
    Products();
  }

  if(document.querySelector(".Cart-item")) {
    Cart();
  }

  if(document.querySelector("#search-form")){
    SearchInput();
  }

  if(document.querySelector("[data-target]")){
    Modal();
  }

  if(document.querySelector('.editProduct')){
    EditProduct();
  }

  if(document.querySelector('.Form-container')){
    ValidateForm();
  }
}

/**
 * Funcionamiento del botón para modificar la cantidad de unidades
 *
 * @param {HTMLElement} parent Elemento (Producto) al cual se modificarán las unidades
 */
function addToCart(parent) {
  const form = parent.querySelector(".Cart");
  if (!form) return;

  const qtyButton = form.querySelector(".Qty");
  const units = form.querySelector('input[name="units"]');
  const max = form.querySelector('input[name="max"]');

  const handleUnits = (qty, unitsInput, max) => {
    max = parseInt(max.value);
    const button = {
      display: qty.querySelector(".Qty__display"),
      addButton: qty.querySelector(".Qty__button--add"),
      removeButton: qty.querySelector(".Qty__button--remove"),
    };

    const updateUnits = (newValue) => {
      unitsInput.value = newValue;
      button.display.textContent = newValue;
    };

    const addUnits = () => {
      let units = parseInt(unitsInput.value);
      if (units === max) return;
      units = units + 1;
      updateUnits(units);
    };

    const removeUnits = () => {
      let units = parseInt(unitsInput.value);
      if (units === 0) return;
      units = units - 1;
      updateUnits(units);
    };

    button.addButton.addEventListener("click", addUnits);
    button.removeButton.addEventListener("click", removeUnits);
  };

  handleUnits(qtyButton, units, max);
}

/**
 * Controla la interactividad relacionada con las cards de los productos
 */
function Products() {
  const Cards = document.querySelectorAll(".Card");
  if (!Cards || !Cards.length > 0) return;

  /**
   * Efecto de rotación de las cards
   *
   * @param {HTMLElement} card Elemento (Producto) con la clase `.Card`
   */
  function handleCardSide(card) {
    const updateClass = (el) => {
      el.classList.toggle("Card--active");
    };

    let front = card.querySelector(".Card__front");
    let button = card.querySelector(".Card__back .Button--back");

    front.addEventListener("click", () => updateClass(card));
    button.addEventListener("click", () => updateClass(card));
  }

  Cards.forEach((card) => {
    handleCardSide(card);
    addToCart(card);
  });
}

/**
 * Controla la interativida relacionada a las cards del carrito de compra
 */
function Cart(){
  const Cards = document.querySelectorAll(".Cart-item");
  if (!Cards || !Cards.length > 0) return;

  Cards.forEach((card) => {
    addToCart(card);
  });
}

/**
 * Controla el funcionamiento de la barra de busqueda
 */
function SearchInput(){
  const form = document.querySelector("#search-form")
  const field = form.querySelector(".Form__field")
  const input = form.querySelector("input[name='search']")
  const icon = form.querySelector(".Form__field .Icon")

  let canSubmit = false;
  let target = "http://localhost/OhMyPet/search/";

  // Modifica la url y envía el formulario
  const submitForm = ( value ) => {
    value = value.trimStart();
    value = encodeURIComponent(value)
    target = `${target}${value}/`
    target = encodeURI(target);

    window.location = target;
  }

  // Evita que el formulario se envíe normalmente
  form.addEventListener( 'submit', (e) => {
    e.preventDefault();
  });

  // Envía el formulario al hacer click sobre el ícono
  icon.addEventListener( 'click', () => {
    let value = input.value.trim()
    if( canSubmit ) submitForm( value );
  });

  // Valida si se puede enviar el formulario
  input.addEventListener( 'keydown', (e) => {
    let value = input.value.trim()
    let length = value.length
    const isReady = () => {
      if( canSubmit ){
        input.classList.remove('Form__input--alert')
        field.classList.add('Form__field--ready')
        
      } else {
        input.classList.add('Form__input--alert')
        field.classList.remove('Form__field--ready')
      }
    }
    
    canSubmit = length > 2
    isReady();

    if ( e.code == 'Enter' && canSubmit ){
      submitForm( value );
    } 
  });
}

/**
 * Controla la apertura y cierre de los modales
 */
function Modal(){
  const handler = ( openButton ) => {
    const open = ( el ) => el.classList.add( 'Modal--active' )
    const close = ( el ) => el.classList.remove( 'Modal--active' )
    
    const modal = document.getElementById( openButton.dataset.target);
    if( !modal ){ return }

    const closeButton = modal.querySelector('.closeButton')
    const overlay = modal.querySelector('.Modal__overlay')

    openButton.addEventListener('click', () => open(modal))
    closeButton.addEventListener('click', () => close(modal))
    overlay.addEventListener('click', () => close(modal))
  }

  const trigger = document.querySelectorAll('[data-target]')
  if ( !trigger || !trigger.length > 0 ) return
  
  trigger.forEach( (el) => handler(el) );
}

/**
 * Modifica la información del modal para editar el producto seleccionado
 */
function EditProduct(){
  // Selecciona cada botón para editar producto
  const trigger = document.querySelectorAll( '.editProduct' )
  if( !trigger || !trigger.length > 0 ) return

  /**
   * Obtiene la información del producto a actualizar
   * 
   * @param {HTMLElement} reference Botón `editar`, a partir de este se selecciona toda la información correspondiente del producto
   * @returns
   */
  const getData = ( reference ) => {
    const table = (reference.parentNode).parentNode
    const product = {
      id : table.querySelector("[data-content='id']").textContent,
      img : table.querySelector("[data-content='img'] img").src,
      name : table.querySelector("[data-content='name']").textContent,
      price : table.querySelector("[data-content='price']").textContent,
      units : table.querySelector("[data-content='units']").textContent,
      content : table.querySelector("[data-content='content']").textContent,
      pet : table.querySelector("[data-content='pet']").textContent,
      category : table.querySelector("[data-content='category']").textContent
    }

    return product
  }

  /**
   * Asigna en los campos del formulario del modal la información obtenida con `getData()`
   * 
   * Devuelve un Objeto con todos los campos del formulario y la información por defecto del `título` y el `botón submit` del mismo
   * 
   * @param {HTMLElement} container Modal donde se asignará la información
   * @param {object} data Información a asignar en el modal
   * @returns 
   */
  const setData = ( container,  data ) => {
    // Crea el campo del id del producto en el formulario
    const form = container.querySelector('.Form')
    form.insertAdjacentHTML('afterbegin', '<input type="hidden" name="id" value></input>');

    // Almacena todos los campos del formulario
    const fields = {
      id : container.querySelector( 'input[name="id"]' ),
      title : container.querySelector( 'h2' ),
      name : container.querySelector( 'input[name="name"]' ),
      price : container.querySelector( 'input[name="price"]' ),
      content : container.querySelector( 'input[name="content"]' ),
      units : container.querySelector( 'input[name="units"]' ),
      pet : container.querySelector( 'select[name="pet"]' ),
      category : container.querySelector( 'select[name="category"]' ),
      button : container.querySelector( 'input[type="submit"]' )
    }

    // Almacena los valores por defecto del formulario
    const defaultValues = {
      title : fields.title.textContent,
      text : fields.button.value,
      name : fields.button.name
    }

    const setSelect = ( select, value ) => {
      const options = select.querySelectorAll('option');
      options.forEach((el) => {
        if (el.textContent === value) el.setAttribute( 'selected', true )
      })
    }

    // Asigna el id del producto al modal
    fields.id.value = data.id

    // Cambia el título del modal
    fields.title.textContent = "Actualiza este producto"

    // Asigna los valores del producto en los inputs correspondientes
    fields.name.value = data.name
    fields.price.value = data.price
    fields.content.value = data.content
    fields.units.value = data.units

    // Asgina los valores del producto en las listas correspondientes
    setSelect( fields.pet, data.pet )
    setSelect( fields.category, data.category )

    // Cambia los datos del botón
    fields.button.value = "Actualizar"
    fields.button.name = "updateProduct"

    return { fields, defaults: defaultValues }
  }

  /**
   * Reestablece la información del modal
   * 
   * @param {HTMLElement} container Modal donde se reestablecerá la información
   * @param {HTMLElement} param1 Objeto con la información de los campos del formulario y los valores por defecto 
   */
  const clearData = ( container, { fields, defaults } ) => {
    const button = container.querySelector('.closeButton')
    const overlay = container.querySelector('.Modal__overlay')

    const close = () => container.classList.remove('Modal--active')
    const reset = () => {
      const resetSelect = (el) => {
        const options = el.querySelectorAll('option')
        options.forEach( (item) => item.removeAttribute("selected") )
      }

      // Elimina el campo del id del producto
      fields.id.remove()

      // Asigna los valores por defecto al modal
      fields.title.textContent = defaults.title
      fields.button.value = defaults.text
      fields.button.name = defaults.name

      // Reinicia el valor de los inputs
      fields.name.value = ''
      fields.price.value = ''
      fields.content.value = ''
      fields.units.value = ''

      // Reinicia el valor de las listas
      resetSelect( fields.pet )
      resetSelect( fields.category )
    }

    button.addEventListener( 'click', () => {
      close()
      setTimeout( reset, 350 )
    })

    overlay.addEventListener( 'click', () => {
      close()
      setTimeout( reset, 350 )
    })
  }

  /**
   * Define un `onclick()` para el elemento `button`
   * Abre el modal para modificar la información del producto
   * 
   * @param {HTMLElement} button 
   */
  const handler = ( button ) => {
    button.addEventListener( 'click', () => {
      const modal = document.getElementById( button.dataset.target )
      const product = getData( button )
      const data = setData( modal, product )

      clearData( modal, data )
    })
  }

  trigger.forEach( (el) => handler(el) );
}

function ValidateForm(){
  const forms = document.querySelectorAll('.Form-container');
  if( !forms || !forms.length > 0 ) return
  
  forms.forEach( (el) => handler(el) )

  function handler( form ){










  }
}