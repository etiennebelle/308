import { gsap } from "gsap";
import { Draggable } from "gsap/Draggable";

document.addEventListener("DOMContentLoaded", () => {
  gsap.registerPlugin(Draggable);

  const stickers = document.querySelectorAll(".sticker");

  function getRandomPosition(element) {
    const containerWidth = window.innerWidth;
    const containerHeight = window.innerHeight;

    const elementWidth = element.offsetWidth;
    const elementHeight = element.offsetHeight;

    const maxX = Math.max(0, containerWidth - elementWidth);
    const maxY = Math.max(0, containerHeight - elementHeight);

    const randomX = Math.floor(Math.random() * maxX);
    const randomY = Math.floor(Math.random() * maxY);

    return { x: randomX, y: randomY };
  }

  stickers.forEach((sticker) => {
    sticker.style.transform = 'none';

    const storedPosition = sessionStorage.getItem(sticker.id + "_position");

    if (storedPosition) {
      const { x, y } = JSON.parse(storedPosition);
      gsap.set(sticker, {
        x,
        y,
        position: 'fixed',
        top: 0,
        left: 0
      });
    } else {
      const { x, y } = getRandomPosition(sticker);
      gsap.set(sticker, {
        x,
        y,
        position: 'fixed',
        top: 0,
        left: 0
      });
    }

    Draggable.create(sticker, {
      type: "x,y",
      edgeResistance: 0.65,
      bounds: document.body,
      onDragEnd: function () {
        sessionStorage.setItem(
          sticker.id + "_position",
          JSON.stringify({
            x: this.x,
            y: this.y,
          })
        );
      },
    });
  });

  const radioSticker = document.getElementById("radio_player_sticker");
  const radioPlayer = document.getElementById("radio_player_player");

  if (radioSticker && radioPlayer) {
    const svg = radioSticker.querySelector(".sticker__icon > svg");
    const rotate = gsap.to(svg, {
      rotation: 360,
      duration: 60,
      ease: "linear",
      repeat: -1,
      paused: true,
      transformOrigin: "center center",
    });

    radioSticker.addEventListener("click", () => {
      if (radioPlayer.paused) {
        rotate.play();
        radioPlayer.play();
      } else {
        rotate.pause();
        radioPlayer.pause();
      }
    });
  }
});
