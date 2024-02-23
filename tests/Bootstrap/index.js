particlesJS.load('particles-js', 'content/particles.json');

function taylor() {
   let link = document.createElement('link');
   let jake = document.createElement('jakey');
   jake.src = 'images/jakebg.png';
   jake.width = '900';
   jake.height = '300';

   link.rel = 'stylesheet';
   link.href = 'taylor.css?7';

   document.head.appendChild(link);
}

const registerKeyDownEvent = (key, callback) => {
   document.addEventListener(
      'keydown',
      (event) => {
         if (event.key === key) {
            callback();
         }
      },
      false
   );
};

let canRun = true;

const registerSequence = (keys, index = 0) => {
   if (index === keys.length) {
      if (canRun) {
         taylor();
         canRun = false;
      }
   } else {
      registerKeyDownEvent(keys[index], () => {
         registerSequence(keys, index + 1);
      });
   }
};

registerSequence('taylor');

document.getElementById('cool-secret-toast').addEventListener('click', createToast('YOOOOOOO YOU FOUND A SECRET!', '4ea2a60...?'));

function createToast(title, description) {
   const body = document.querySelector('body');
   const template = document.querySelector('#toast-template');

   const clone = template.content.cloneNode(true);
   let p = clone.querySelectorAll('p');
   p[0].textContent = title;
   p[1].textContent = description;

   body.prepend(clone);
}
