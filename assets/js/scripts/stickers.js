import { gsap } from "gsap";
import { Draggable } from "gsap/Draggable";
document.addEventListener('DOMContentLoaded', () => {
  gsap.registerPlugin(Draggable);
  const stickers = document.querySelectorAll('.sticker');

  stickers.forEach(sticker => {
    // Random positioning
    const randomX = Math.floor(Math.random() * 80) + 10;
    const randomY = Math.floor(Math.random() * 80) + 10;

    sticker.style.position = 'fixed';
    sticker.style.left = `${randomX}%`;
    sticker.style.top = `${randomY}%`;
    sticker.style.transform = 'translate(-50%, -50%)';

    Draggable.create(sticker, {
      type: "x,y",
      edgeResistance: 0.65,
      bounds: document.body,
    });
  });

  const radioSticker = document.getElementById('radio_player_sticker');
  const radioPlayer = document.getElementById('radio_player_player');

  if(radioSticker && radioPlayer) {
    const svg = radioSticker.querySelector('.sticker__icon > svg')
    const rotate = gsap.to(svg, {
      rotation: 360,
      duration: 60,
      ease: "linear",
      repeat: -1,
      paused: true,
      transformOrigin: "center center"
    });

    radioSticker.addEventListener('click', () => {
      if(radioPlayer.paused){
        rotate.play();
        radioPlayer.play();
      } else {
        rotate.pause();
        radioPlayer.pause();
      }
    });
  }
});