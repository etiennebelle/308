import { gsap } from "gsap";
import { Draggable } from "gsap/Draggable";

document.addEventListener("DOMContentLoaded", () => {
  gsap.registerPlugin(Draggable);

  const stickers = document.querySelectorAll(".sticker");

  stickers.forEach((sticker) => {
    const storedPosition = sessionStorage.getItem(sticker.id + "_position");

    if (storedPosition) {
      const { x, y } = JSON.parse(storedPosition);

      gsap.set(sticker, {
        x: x,
        y: y,
      });
    } else {
      const randomX = Math.floor(Math.random() * window.innerWidth * 0.8);
      const randomY = Math.floor(Math.random() * window.innerHeight * 0.8);

      gsap.set(sticker, {
        x: randomX,
        y: randomY,
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
