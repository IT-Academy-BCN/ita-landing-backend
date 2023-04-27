
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
<section class="modal fixed top-0 left-0 right-0 bottom-0 flex">
    <div class="modal__container">
        <p class="modal__x">x</p>
        <h2 class="modal__title text-2xl font-bold leading-4">Normativa</h2>
        <p class="modal__paragraph font-medium leading-5 text-base">Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in felis ac justo pretium facilisis et quis libero. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc a est ac ante condimentum porta ac quis libero. Mauris luctus, est facilisis suscipit aliquet, velit nisl finibus ligula, eu tempus libero urna in est. Nullam vitae mattis est, sit amet congue massa. Aliquam fermentum, dolor in tincidunt elementum, dui justo ultrices tellus, ut eleifend sapien ipsum at ipsum. Praesent in egestas purus, nec elementum velit. Suspendisse potenti. Aliquam vitae suscipit diam. Phasellus a nunc ut sapien scelerisque pretium. Sed vulputate viverra erat.<br><br>

          Aliquam ac eros nec magna euismod posuere. Integer a fringilla orci, id gravida nisl. Praesent nec sollicitudin ante, id dapibus quam. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed at nisi a odio dictum tincidunt sit amet quis felis. Nulla facilisi. Nullam sagittis mi vitae risus aliquet fringilla. Sed eget purus vel massa molestie gravida nec consequat massa. Integer felis lectus, vulputate id risus sit amet, tempus dapibus dolor. Duis eu maximus elit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Mauris pellentesque turpis eu erat aliquet malesuada. Praesent congue libero et ante pretium faucibus. Praesent eu auctor nisi.<br><br>
          
          Nullam vel laoreet ligula. Proin vel augue commodo, malesuada ligula ut, pretium nisl. Praesent nunc ligula, egestas eu lorem non, sollicitudin aliquet massa. Quisque hendrerit leo felis, a tristique turpis varius ut. Sed ullamcorper tempus turpis, non tincidunt lorem consectetur nec. Duis fermentum, augue sed sollicitudin lobortis, justo metus volutpat neque, et tristique nulla neque ut elit. Fusce non est nec enim suscipit venenatis non vel dui.</p>
        <a href="#" class="modal__close font-bold	text-base	leading-4	">Entendido</a>
    </div>
</section>
<style>
section {
        font-family: Poppins;
    }
.modal{
  background-color: #111111bd;
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
margin: 10px auto 0 auto;
width: 90%;
height: 90%;
max-width: 75%;
max-height: 90%;
background-color: white;
border-radius: 6px;
padding: 3em 2.5em;
display: grid;

place-items: center;
}

.modal__title{
  font-size: 2.5rem;
  margin: 20px 0;
}

.modal__x{
  margin:0;
  place-self: end;
  font-size: 20px;
  font-weight: bold;
  cursor: pointer;
}

.modal__paragraph{
  margin-bottom: 20px;
  margin-top: 20px;
  overflow-y: auto;
  max-height: 200px; 
}

.modal__close{
  margin-top: 10px;
  margin-bottom: 10px;
  text-decoration: none;
  color: #fff;
  background-color: #B91879;
  padding: 1em 6em;
  border: 1px solid ;
  border-radius: 12px;
  display: inline-block;
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
  const closeX = document.querySelector('.modal__x');

  openModal.addEventListener('click', (e)=>{
    e.preventDefault();
    modal.classList.add('modal--show');
});

  closeModal.addEventListener('click', (e)=>{
      e.preventDefault();
      modal.classList.remove('modal--show');
});

  closeX.addEventListener('click', (e)=>{
      e.preventDefault();
      modal.classList.remove('modal--show');
});

</script>