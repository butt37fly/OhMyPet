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
  if (document.querySelector(".Card")) {
    Products();
  }

  if (document.querySelector(".Cart-item")) {
    Cart();
  }

  if( document.querySelector("#search-form")){
    SearchInput();
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

/*
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
