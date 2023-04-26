<section class="modal">
    <div class="modal__container">
        <p class="modal__x">X</p>
        <h2 class="modal__title">Normativa</h2>
        <p class="modal__paragraph">In et aliquet augue. Vivamus egestas nisi sit amet eleifend consequat. Quisque nec lobortis erat, vitae ultrices lacus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam dapibus dolor et purus faucibus, ac sodales tellus pulvinar. Phasellus gravida enim sit amet est iaculis condimentum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec sit amet ligula quis eros maximus scelerisque ac ut tellus. Quisque massa ante, rutrum quis rutrum sit amet, porta id sapien. Nullam blandit, lectus mollis fringilla cursus, velit leo facilisis metus, quis pretium massa neque rhoncus neque.</p>
        <a href="#" class="modal__close">Entendido</a>
    </div>
</section>
<style>
.modal{
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #111111bd;
  display: flex;
  opacity: 0;
  pointer-events: none;
  transition: opacity .6s .9s;
  --transform: translateY(-100vh);
  --transition: transform .8s;
}

.modal--show{
  opacity: 1;
  pointer-events: unset;
  transition: opacity .6s;
  --transform: translateY(0);
  --transition: transform .8s .8s;
}

.modal__container{
margin: auto;
width: 90%;
max-width: 600px;
max-height: 90%;
background-color: white;
border-radius: 6px;
padding: 3em 2.5em;
display: grid;
gap: 1em;
place-items: center;


}

.modal__title{
  font-size: 2.5rem;
}

.modal__paragraph{
  margin-bottom: 10px;
}

.modal__close{
  text-decoration: none;
  color: #fff;
  background-color: #B91879;

;
  padding: 1em 3em;
  border: 1px solid ;
  border-radius: 6px;
  display: inline-block;
  font-weight: 300;
  transition: background-color .3s;
}

.modal__close:hover{
  color: #f3abd6;
  background-color: #fff;
}

@media (max-width:768px) {

.modal__container{
      padding: 2em 1.5em;
  }

.modal__title{
    font-size: 2rem;
  }
}
</style>

<script>
  const openModal = document.querySelector('#norms');
  const modal = document.querySelector('.modal');
  const closeModal = document.querySelector('.modal__close');

  openModal.addEventListener('click', (e)=>{
    e.preventDefault();
    modal.classList.add('modal--show');
});

  closeModal.addEventListener('click', (e)=>{
      e.preventDefault();
      modal.classList.remove('modal--show');
});

</script>