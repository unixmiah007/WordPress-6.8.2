// document.addEventListener('DOMContentLoaded', function () {
//     const marquees = document.querySelectorAll('.stea-marquee-wrapper');
  
//     // Initialize all marquees
//     marquees.forEach(initMarquee);
  
//     // Use ResizeObserver for responsive behavior
//     const resizeObserver = new ResizeObserver(entries => {
//       entries.forEach(entry => {
//         const marquee = entry.target;
//         if (marquee._tl) marquee._tl.kill();
//         initMarquee(marquee);
//       });
//     });
  
//     marquees.forEach(marquee => {
//       resizeObserver.observe(marquee);
//     });
  
//     function initMarquee(marquee) {
//       const rail = marquee.querySelector('.stea-marquee-rail');
//       const items = marquee.querySelectorAll('.stea-marquee-item:not(.clone)');
//       const speed = parseFloat(marquee.dataset.speed) || 1;
//       const direction = marquee.dataset.direction || 'left';
  
//       if (!items.length) return;
  
//       // Clear previous clones
//       rail.querySelectorAll('.clone').forEach(clone => clone.remove());
  
//       // Calculate total width
//       let totalWidth = 0;
//       items.forEach(item => {
//         const style = getComputedStyle(item);
//         totalWidth += item.offsetWidth + parseFloat(style.marginRight);
//       });
  
//       const viewportWidth = marquee.offsetWidth;
//       const clonesNeeded = Math.max(2, Math.ceil(viewportWidth / totalWidth) + 1);
  
//       // Create clones
//       for (let i = 0; i < clonesNeeded; i++) {
//         items.forEach(item => {
//           const clone = item.cloneNode(true);
//           clone.classList.add('clone');
//           rail.appendChild(clone);
//         });
//       }
  
//       // Recalculate width after cloning
//       const fullContentWidth = totalWidth * (clonesNeeded + 1);
  
//       // Determine scroll direction
//       const isLTR = direction === 'right' || direction === 'ltr';
  
//       if (marquee._tl) marquee._tl.kill();
  
//       gsap.set(rail, { x: 0 });
  
//       if (isLTR) {
//         // Left to Right
//         marquee._tl = gsap.timeline({ repeat: -1 })
//           .to(rail, {
//             x: fullContentWidth,
//             duration: fullContentWidth / (100 * speed),
//             ease: "none",
//           })
//           .set(rail, { x: 0 });
//       } else {
//         // Right to Left
//         marquee._tl = gsap.timeline({ repeat: -1 })
//           .to(rail, {
//             x: -fullContentWidth,
//             duration: fullContentWidth / (100 * speed),
//             ease: "none",
//           })
//           .set(rail, { x: 0 });
//       }
  
//       // Pause on hover
//       marquee.addEventListener('mouseenter', () => marquee._tl.pause());
//       marquee.addEventListener('mouseleave', () => marquee._tl.play());
//     }
//   });
  



// four times ke bad empty aara tha per baki chlra tha
// document.addEventListener('DOMContentLoaded', function () {
//   console.clear();
//   gsap.registerPlugin(Observer);

//   const marquees = document.querySelectorAll('.stea-marquee-wrapper');

//   marquees.forEach(marquee => {
//     const rail = marquee.querySelector('.stea-marquee-rail');
//     const items = Array.from(rail.querySelectorAll('.stea-marquee-item'));
//     const baseSpeed = parseFloat(marquee.dataset.speed) || 1;
//     const direction = marquee.dataset.direction || 'left';

//     // ⭐ Clone items until rail is wide enough
//     cloneUntilFill(rail, items, marquee.offsetWidth * 2);

//     const allItems = gsap.utils.toArray(rail.querySelectorAll('.stea-marquee-item'));

//     const tl = horizontalLoop(allItems, {
//       repeat: -1,
//       speed: baseSpeed,
//       reversed: direction === 'right' || direction === 'rtl',
//       paddingRight: 30,
//     });

//     Observer.create({
//       target: window,
//       type: "wheel,touch,pointer",
//       onChangeY(self) {
//         let factor = 2.5;
//         if (self.deltaY < 0) {
//           factor *= -1;
//         }

//         const isReversed = tl.reversed();

//         gsap.timeline({ defaults: { ease: "none" } })
//           .to(tl, {
//             timeScale: isReversed ? -factor * 2.5 : factor * 2.5,
//             duration: 0.2,
//             overwrite: true
//           })
//           .to(tl, {
//             timeScale: isReversed ? -1 : 1,
//             duration: 1
//           }, "+=0.3");
//       }
//     });
//   });

//   function cloneUntilFill(rail, items, targetWidth) {
//     let currentWidth = rail.scrollWidth;
//     while (currentWidth < targetWidth) {
//       items.forEach(item => {
//         const clone = item.cloneNode(true);
//         clone.classList.add('clone');
//         rail.appendChild(clone);
//       });
//       currentWidth = rail.scrollWidth;
//     }
//   }

//   function horizontalLoop(items, config) {
//     items = gsap.utils.toArray(items);
//     config = config || {};
//     let tl = gsap.timeline({
//         repeat: config.repeat,
//         paused: config.paused,
//         defaults: { ease: "none" },
//         onReverseComplete: () => tl.totalTime(tl.rawTime() + tl.duration() * 100)
//       }),
//       length = items.length,
//       startX = items[0].offsetLeft,
//       times = [],
//       widths = [],
//       xPercents = [],
//       curIndex = 0,
//       pixelsPerSecond = (config.speed || 1) * 100,
//       snap = config.snap === false ? v => v : gsap.utils.snap(config.snap || 1),
//       totalWidth, curX, distanceToStart, distanceToLoop, item, i;

//     gsap.set(items, {
//       xPercent: (i, el) => {
//         let w = widths[i] = parseFloat(gsap.getProperty(el, "width", "px"));
//         xPercents[i] = snap(parseFloat(gsap.getProperty(el, "x", "px")) / w * 100 + gsap.getProperty(el, "xPercent"));
//         return xPercents[i];
//       }
//     });
//     gsap.set(items, { x: 0 });

//     totalWidth = items[length-1].offsetLeft + xPercents[length-1] / 100 * widths[length-1] - startX + items[length-1].offsetWidth * gsap.getProperty(items[length-1], "scaleX") + (parseFloat(config.paddingRight) || 0);

//     for (i = 0; i < length; i++) {
//       item = items[i];
//       curX = xPercents[i] / 100 * widths[i];
//       distanceToStart = item.offsetLeft + curX - startX;
//       distanceToLoop = distanceToStart + widths[i] * gsap.getProperty(item, "scaleX");

//       tl.to(item, { xPercent: snap((curX - distanceToLoop) / widths[i] * 100), duration: distanceToLoop / pixelsPerSecond }, 0)
//         .fromTo(item, { xPercent: snap((curX - distanceToLoop + totalWidth) / widths[i] * 100) }, { xPercent: xPercents[i], duration: (curX - distanceToLoop + totalWidth - curX) / pixelsPerSecond, immediateRender: false }, distanceToLoop / pixelsPerSecond)
//         .add("label" + i, distanceToStart / pixelsPerSecond);

//       times[i] = distanceToStart / pixelsPerSecond;
//     }

//     function toIndex(index, vars) {
//       vars = vars || {};
//       (Math.abs(index - curIndex) > length / 2) && (index += index > curIndex ? -length : length);
//       let newIndex = gsap.utils.wrap(0, length, index),
//         time = times[newIndex];
//       if (time > tl.time() !== index > curIndex) {
//         vars.modifiers = { time: gsap.utils.wrap(0, tl.duration()) };
//         time += tl.duration() * (index > curIndex ? 1 : -1);
//       }
//       curIndex = newIndex;
//       vars.overwrite = true;
//       return tl.tweenTo(time, vars);
//     }

//     tl.next = vars => toIndex(curIndex + 1, vars);
//     tl.previous = vars => toIndex(curIndex - 1, vars);
//     tl.current = () => curIndex;
//     tl.toIndex = (index, vars) => toIndex(index, vars);
//     tl.times = times;
//     tl.progress(1, true).progress(0, true);

//     if (config.reversed) {
//       tl.vars.onReverseComplete();
//       tl.reverse();
//     }

//     return tl;
//   }
// });




// Added animation setting
// document.addEventListener('DOMContentLoaded', function () {
//   console.clear();
//   gsap.registerPlugin(Observer);

//   const marquees = document.querySelectorAll('.stea-marquee-wrapper');

//   marquees.forEach(marquee => {
//     const rail = marquee.querySelector('.stea-marquee-rail');
//     const items = Array.from(rail.querySelectorAll('.stea-marquee-item'));
//     const baseSpeed = parseFloat(marquee.dataset.speed) || 1;
//     const direction = marquee.dataset.direction || 'left';
//     const enableScrollAnimation = marquee.dataset.scrollAnimation === 'yes';

//     // Clone items until rail is wide enough
//     cloneUntilFill(rail, items, marquee.offsetWidth * 2);

//     const allItems = gsap.utils.toArray(rail.querySelectorAll('.stea-marquee-item'));

//     const tl = horizontalLoop(allItems, {
//       repeat: -1,
//       speed: baseSpeed,
//       reversed: direction === 'right' || direction === 'rtl',
//       paddingRight: parseFloat(marquee.dataset.spacing) || 30,
//     });

//     // Only add scroll interaction if enabled
//     if (enableScrollAnimation) {
//       Observer.create({
//         target: window,
//         type: "wheel,touch,pointer",
//         onChangeY(self) {
//           let factor = 2.5;
//           if (self.deltaY < 0) {
//             factor *= -1;
//           }

//           const isReversed = tl.reversed();

//           gsap.timeline({ defaults: { ease: "none" } })
//             .to(tl, {
//               timeScale: isReversed ? -factor * 2.5 : factor * 2.5,
//               duration: 0.2,
//               overwrite: true
//             })
//             .to(tl, {
//               timeScale: isReversed ? -1 : 1,
//               duration: 1
//             }, "+=0.3");
//         }
//       });
//     }

//     // Handle hover effects if needed
//     marquee.addEventListener('mouseenter', () => {
//       gsap.to(tl, { timeScale: 0.5, duration: 0.3 });
//     });

//     marquee.addEventListener('mouseleave', () => {
//       gsap.to(tl, { 
//         timeScale: direction === 'right' || direction === 'rtl' ? -1 : 1, 
//         duration: 0.3 
//       });
//     });
//   });

//   function cloneUntilFill(rail, items, targetWidth) {
//     let currentWidth = rail.scrollWidth;
//     while (currentWidth < targetWidth) {
//       items.forEach(item => {
//         const clone = item.cloneNode(true);
//         clone.classList.add('clone');
//         rail.appendChild(clone);
//       });
//       currentWidth = rail.scrollWidth;
//     }
//   }

//   function horizontalLoop(items, config) {
//     items = gsap.utils.toArray(items);
//     config = config || {};
//     let tl = gsap.timeline({
//         repeat: config.repeat,
//         paused: config.paused,
//         defaults: { ease: "none" },
//         onReverseComplete: () => tl.totalTime(tl.rawTime() + tl.duration() * 100)
//       }),
//       length = items.length,
//       startX = items[0].offsetLeft,
//       times = [],
//       widths = [],
//       xPercents = [],
//       curIndex = 0,
//       pixelsPerSecond = (config.speed || 1) * 100,
//       snap = config.snap === false ? v => v : gsap.utils.snap(config.snap || 1),
//       totalWidth, curX, distanceToStart, distanceToLoop, item, i;

//     gsap.set(items, {
//       xPercent: (i, el) => {
//         let w = widths[i] = parseFloat(gsap.getProperty(el, "width", "px"));
//         xPercents[i] = snap(parseFloat(gsap.getProperty(el, "x", "px")) / w * 100 + gsap.getProperty(el, "xPercent"));
//         return xPercents[i];
//       }
//     });
//     gsap.set(items, { x: 0 });

//     totalWidth = items[length-1].offsetLeft + xPercents[length-1] / 100 * widths[length-1] - startX + items[length-1].offsetWidth * gsap.getProperty(items[length-1], "scaleX") + (parseFloat(config.paddingRight) || 0);

//     for (i = 0; i < length; i++) {
//       item = items[i];
//       curX = xPercents[i] / 100 * widths[i];
//       distanceToStart = item.offsetLeft + curX - startX;
//       distanceToLoop = distanceToStart + widths[i] * gsap.getProperty(item, "scaleX");

//       tl.to(item, { xPercent: snap((curX - distanceToLoop) / widths[i] * 100), duration: distanceToLoop / pixelsPerSecond }, 0)
//         .fromTo(item, { xPercent: snap((curX - distanceToLoop + totalWidth) / widths[i] * 100) }, { xPercent: xPercents[i], duration: (curX - distanceToLoop + totalWidth - curX) / pixelsPerSecond, immediateRender: false }, distanceToLoop / pixelsPerSecond)
//         .add("label" + i, distanceToStart / pixelsPerSecond);

//       times[i] = distanceToStart / pixelsPerSecond;
//     }

//     function toIndex(index, vars) {
//       vars = vars || {};
//       (Math.abs(index - curIndex) > length / 2) && (index += index > curIndex ? -length : length);
//       let newIndex = gsap.utils.wrap(0, length, index),
//         time = times[newIndex];
//       if (time > tl.time() !== index > curIndex) {
//         vars.modifiers = { time: gsap.utils.wrap(0, tl.duration()) };
//         time += tl.duration() * (index > curIndex ? 1 : -1);
//       }
//       curIndex = newIndex;
//       vars.overwrite = true;
//       return tl.tweenTo(time, vars);
//     }

//     tl.next = vars => toIndex(curIndex + 1, vars);
//     tl.previous = vars => toIndex(curIndex - 1, vars);
//     tl.current = () => curIndex;
//     tl.toIndex = (index, vars) => toIndex(index, vars);
//     tl.times = times;
//     tl.progress(1, true).progress(0, true);

//     if (config.reversed) {
//       tl.vars.onReverseComplete();
//       tl.reverse();
//     }

//     return tl;
//   }
// });




// improve animation and hover efect setting
document.addEventListener('DOMContentLoaded', function () {
  console.clear();
  gsap.registerPlugin(Observer);

  const marquees = document.querySelectorAll('.stea-marquee-wrapper');

  marquees.forEach(marquee => {
    const rail = marquee.querySelector('.stea-marquee-rail');
    const items = Array.from(rail.querySelectorAll('.stea-marquee-item'));
    const baseSpeed = parseFloat(marquee.dataset.speed) || 1;
    const direction = marquee.dataset.direction || 'ltr';
    const enableScrollAnimation = marquee.dataset.scrollAnimation === 'yes';
    const pauseOnHover = marquee.dataset.pauseOnHover === 'yes';

    // Clone items until rail is wide enough
    cloneUntilFill(rail, items, marquee.offsetWidth * 2);

    const allItems = gsap.utils.toArray(rail.querySelectorAll('.stea-marquee-item'));

    const tl = horizontalLoop(allItems, {
      repeat: -1,
      speed: baseSpeed,
      reversed: direction === 'rtl', // Only reverse for RTL direction
      paddingRight: parseFloat(marquee.dataset.spacing) || 30,
    });

    // Scroll animation if enabled
    if (enableScrollAnimation) {
      Observer.create({
        target: window,
        type: "wheel,touch,pointer",
        onChangeY(self) {
          let factor = 2.5;
          if (self.deltaY < 0) {
            factor *= -1;
          }

          const isReversed = tl.reversed();

          gsap.timeline({ defaults: { ease: "none" } })
            .to(tl, {
              timeScale: isReversed ? -factor * 2.5 : factor * 2.5,
              duration: 0.2,
              overwrite: true
            })
            .to(tl, {
              timeScale: isReversed ? -1 : 1,
              duration: 1
            }, "+=0.3");
        }
      });
    }

    // Pause on hover if enabled
    if (pauseOnHover) {
      marquee.addEventListener('mouseenter', () => {
        gsap.to(tl, { timeScale: 0, duration: 0.3 });
      });

      marquee.addEventListener('mouseleave', () => {
        gsap.to(tl, { 
          timeScale: direction === 'rtl' ? -1 : 1, 
          duration: 0.3 
        });
      });
    }
  });

  function cloneUntilFill(rail, items, targetWidth) {
    let currentWidth = rail.scrollWidth;
    while (currentWidth < targetWidth) {
      items.forEach(item => {
        const clone = item.cloneNode(true);
        clone.classList.add('clone');
        rail.appendChild(clone);
      });
      currentWidth = rail.scrollWidth;
    }
  }

  function horizontalLoop(items, config) {
    items = gsap.utils.toArray(items);
    config = config || {};
    let tl = gsap.timeline({
        repeat: config.repeat,
        paused: config.paused,
        defaults: { ease: "none" },
        onReverseComplete: () => tl.totalTime(tl.rawTime() + tl.duration() * 100)
      }),
      length = items.length,
      startX = items[0].offsetLeft,
      times = [],
      widths = [],
      xPercents = [],
      curIndex = 0,
      pixelsPerSecond = (config.speed || 1) * 100,
      snap = config.snap === false ? v => v : gsap.utils.snap(config.snap || 1),
      totalWidth, curX, distanceToStart, distanceToLoop, item, i;

    gsap.set(items, {
      xPercent: (i, el) => {
        let w = widths[i] = parseFloat(gsap.getProperty(el, "width", "px"));
        xPercents[i] = snap(parseFloat(gsap.getProperty(el, "x", "px")) / w * 100 + gsap.getProperty(el, "xPercent"));
        return xPercents[i];
      }
    });
    gsap.set(items, { x: 0 });

    totalWidth = items[length-1].offsetLeft + xPercents[length-1] / 100 * widths[length-1] - startX + items[length-1].offsetWidth * gsap.getProperty(items[length-1], "scaleX") + (parseFloat(config.paddingRight) || 0);

    for (i = 0; i < length; i++) {
      item = items[i];
      curX = xPercents[i] / 100 * widths[i];
      distanceToStart = item.offsetLeft + curX - startX;
      distanceToLoop = distanceToStart + widths[i] * gsap.getProperty(item, "scaleX");

      tl.to(item, { xPercent: snap((curX - distanceToLoop) / widths[i] * 100), duration: distanceToLoop / pixelsPerSecond }, 0)
        .fromTo(item, { xPercent: snap((curX - distanceToLoop + totalWidth) / widths[i] * 100) }, { xPercent: xPercents[i], duration: (curX - distanceToLoop + totalWidth - curX) / pixelsPerSecond, immediateRender: false }, distanceToLoop / pixelsPerSecond)
        .add("label" + i, distanceToStart / pixelsPerSecond);

      times[i] = distanceToStart / pixelsPerSecond;
    }

    function toIndex(index, vars) {
      vars = vars || {};
      (Math.abs(index - curIndex) > length / 2) && (index += index > curIndex ? -length : length);
      let newIndex = gsap.utils.wrap(0, length, index),
        time = times[newIndex];
      if (time > tl.time() !== index > curIndex) {
        vars.modifiers = { time: gsap.utils.wrap(0, tl.duration()) };
        time += tl.duration() * (index > curIndex ? 1 : -1);
      }
      curIndex = newIndex;
      vars.overwrite = true;
      return tl.tweenTo(time, vars);
    }

    tl.next = vars => toIndex(curIndex + 1, vars);
    tl.previous = vars => toIndex(curIndex - 1, vars);
    tl.current = () => curIndex;
    tl.toIndex = (index, vars) => toIndex(index, vars);
    tl.times = times;
    tl.progress(1, true).progress(0, true);

    if (config.reversed) {
      tl.vars.onReverseComplete();
      tl.reverse();
    }

    return tl;
  }
});
