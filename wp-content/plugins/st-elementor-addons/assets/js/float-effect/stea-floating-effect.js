// /**
//  * ST Elementor Addons - Floating Effects
//  * Handles all floating animation effects for Elementor widgets
//  */
// (function($) {
//     'use strict';

//     $(window).on('elementor/frontend/init', function() {

//         var FloatingHandler = elementorModules.frontend.handlers.Base.extend({

//             /**
//              * Bind events
//              */
//             bindEvents: function() {
//                 console.log('STEA Floating: Binding events');
//                 this.run();
//             },

//             /**
//              * Default animation settings
//              */
//             getDefaultSettings: function() {
//                 return {
//                     direction: 'alternate',
//                     easing: 'easeInOutSine',
//                     loop: true,
//                     targets: this.$element[0],
//                     autoplay: false // We'll manually start animations
//                 };
//             },

//             /**
//              * Debounce function to prevent rapid firing
//              */
//             debounce: function(func, wait, immediate) {
//                 var timeout;
//                 return function() {
//                     var context = this, args = arguments;
//                     var later = function() {
//                         timeout = null;
//                         if (!immediate) func.apply(context, args);
//                     };
//                     var callNow = immediate && !timeout;
//                     clearTimeout(timeout);
//                     timeout = setTimeout(later, wait);
//                     if (callNow) func.apply(context, args);
//                 };
//             },

//             /**
//              * Get floating effect setting value
//              */
//             getFxVal: function(prop) {
//                 return this.getElementSettings('stea_floating_fx_' + prop);
//             },

//             /**
//              * Main animation runner
//              */
//             run: function() {
//                 // Check if anime.js is loaded
//                 if (typeof anime === 'undefined') {
//                     console.error('STEA Floating: anime.js is not loaded');
//                     return;
//                 }

//                 console.log('STEA Floating: Running animation setup');
                
//                 var settings = this.getDefaultSettings();
//                 var hasEffect = false;

//                 // 1. TRANSLATE EFFECTS
//                 if (this.getFxVal('translate_toggle') === 'yes') {
//                     console.log('STEA Floating: Translate effect enabled');
//                     hasEffect = true;

//                     // Translate X
//                     var translateX = this.getFxVal('translate_x');
//                     if (translateX && (translateX.size || translateX.sizes.to)) {
//                         settings.translateX = {
//                             value: [
//                                 translateX.sizes.from || 0,
//                                 translateX.size || translateX.sizes.to || 20
//                             ],
//                             duration: this.getFxVal('translate_duration')?.size || 1000,
//                             delay: this.getFxVal('translate_delay')?.size || 0
//                         };
//                     }

//                     // Translate Y
//                     var translateY = this.getFxVal('translate_y');
//                     if (translateY && (translateY.size || translateY.sizes.to)) {
//                         settings.translateY = {
//                             value: [
//                                 translateY.sizes.from || 0,
//                                 translateY.size || translateY.sizes.to || 20
//                             ],
//                             duration: this.getFxVal('translate_duration')?.size || 1000,
//                             delay: this.getFxVal('translate_delay')?.size || 0
//                         };
//                     }
//                 }

//                 // 2. ROTATE EFFECTS
//                 if (this.getFxVal('rotate_toggle') === 'yes') {
//                     console.log('STEA Floating: Rotate effect enabled');
//                     hasEffect = true;

//                     var rotateMode = this.getFxVal('rotate_mode') || 'loose';

//                     // Rotate X (loose mode)
//                     if (rotateMode === 'loose') {
//                         var rotateX = this.getFxVal('rotate_x');
//                         if (rotateX && (rotateX.size || rotateX.sizes.to)) {
//                             settings.rotateX = {
//                                 value: [
//                                     rotateX.sizes.from || 0,
//                                     rotateX.size || rotateX.sizes.to || 30
//                                 ],
//                                 duration: this.getFxVal('rotate_duration')?.size || 1000,
//                                 delay: this.getFxVal('rotate_delay')?.size || 0
//                             };
//                         }

//                         // Rotate Y (loose mode)
//                         var rotateY = this.getFxVal('rotate_y');
//                         if (rotateY && (rotateY.size || rotateY.sizes.to)) {
//                             settings.rotateY = {
//                                 value: [
//                                     rotateY.sizes.from || 0,
//                                     rotateY.size || rotateY.sizes.to || 0
//                                 ],
//                                 duration: this.getFxVal('rotate_duration')?.size || 1000,
//                                 delay: this.getFxVal('rotate_delay')?.size || 0
//                             };
//                         }
//                     }

//                     // Rotate Z (compact mode)
//                     var rotateZ = this.getFxVal('rotate_z');
//                     if (rotateZ && (rotateZ.size || rotateZ.sizes.to)) {
//                         settings.rotateZ = {
//                             value: [
//                                 rotateZ.sizes.from || 0,
//                                 rotateZ.size || rotateZ.sizes.to || 30
//                             ],
//                             duration: this.getFxVal('rotate_duration')?.size || 1000,
//                             delay: this.getFxVal('rotate_delay')?.size || 0
//                         };
//                     }
//                 }

//                 // 3. SCALE EFFECTS
//                 if (this.getFxVal('scale_toggle') === 'yes') {
//                     console.log('STEA Floating: Scale effect enabled');
//                     hasEffect = true;

//                     var scaleMode = this.getFxVal('scale_mode') || 'loose';

//                     // Scale X (loose mode)
//                     if (scaleMode === 'loose') {
//                         var scaleX = this.getFxVal('scale_x');
//                         if (scaleX && (scaleX.size || scaleX.sizes.to)) {
//                             settings.scaleX = {
//                                 value: [
//                                     scaleX.sizes.from || 1,
//                                     scaleX.size || scaleX.sizes.to || 1.2
//                                 ],
//                                 duration: this.getFxVal('scale_duration')?.size || 1000,
//                                 delay: this.getFxVal('scale_delay')?.size || 0
//                             };
//                         }

//                         // Scale Y (loose mode)
//                         var scaleY = this.getFxVal('scale_y');
//                         if (scaleY && (scaleY.size || scaleY.sizes.to)) {
//                             settings.scaleY = {
//                                 value: [
//                                     scaleY.sizes.from || 1,
//                                     scaleY.size || scaleY.sizes.to || 1
//                                 ],
//                                 duration: this.getFxVal('scale_duration')?.size || 1000,
//                                 delay: this.getFxVal('scale_delay')?.size || 0
//                             };
//                         }
//                     }

//                     // Scale (compact mode)
//                     var scaleZ = this.getFxVal('scale_z');
//                     if (scaleZ && (scaleZ.size || scaleZ.sizes.to)) {
//                         settings.scale = {
//                             value: [
//                                 scaleZ.sizes.from || 1,
//                                 scaleZ.size || scaleZ.sizes.to || 1.2
//                             ],
//                             duration: this.getFxVal('scale_duration')?.size || 1000,
//                             delay: this.getFxVal('scale_delay')?.size || 0
//                         };
//                     }
//                 }

//                 // Apply the animation if any effect is enabled
//                 if (hasEffect) {
//                     console.log('STEA Floating: Applying animation effects');
//                     this.$element.css('will-change', 'transform');
                    
//                     if (this.animation) {
//                         // Restart existing animation
//                         this.animation.restart();
//                     } else {
//                         // Create new animation
//                         this.animation = anime(settings);
//                     }
//                 } else if (this.animation) {
//                     // Remove animation if no effects are enabled
//                     console.log('STEA Floating: Removing animation');
//                     anime.remove(this.animation);
//                     this.animation = null;
//                 }
//             },

//             /**
//              * Handle Elementor setting changes
//              */
//             onElementChange: function(setting) {
//                 if (setting.indexOf('stea_floating_fx') !== -1) {
//                     console.log('STEA Floating: Detected setting change - ' + setting);
//                     this.debounce(this.run.bind(this), 300)();
//                 }
//             }
//         });

//         // Register the handler for all widgets
//         elementorFrontend.hooks.addAction(
//             'frontend/element_ready/widget',
//             function($element) {
//                 console.log('STEA Floating: Initializing for element');
//                 elementorFrontend.elementsHandler.addHandler(
//                     FloatingHandler,
//                     { $element: $element }
//                 );
//             }
//         );
//     });
// })(jQuery);





// working

// (function($) {
//     'use strict';

//     $(window).on('elementor/frontend/init', function() {
        
//         var FloatingHandler = elementorModules.frontend.handlers.Base.extend({
            
//             bindEvents: function() {
//                 this.run();
//             },

//             getDefaultSettings: function() {
//                 return {
//                     targets: this.$element[0],
//                     direction: 'alternate',
//                     easing: 'easeInOutSine',
//                     loop: true,
//                     autoplay: true
//                 };
//             },

//             getFxVal: function(prop) {
//                 return this.getElementSettings('stea_floating_fx_' + prop);
//             },

//             run: function() {
//                 // Check if anime.js is loaded
//                 if (typeof anime === 'undefined') {
//                     console.error('STEA Floating: anime.js is not loaded');
//                     return;
//                 }

//                 var settings = this.getDefaultSettings();
//                 var hasEffect = false;

//                 // Translate Effects
//                 if (this.getFxVal('translate_toggle') === 'yes') {
//                     var translateX = this.getFxVal('translate_x');
//                     var translateY = this.getFxVal('translate_y');

//                     if (translateX && (translateX.size || translateX.sizes.to)) {
//                         settings.translateX = [
//                             translateX.sizes.from || 0,
//                             translateX.size || translateX.sizes.to || 20
//                         ];
//                         hasEffect = true;
//                     }

//                     if (translateY && (translateY.size || translateY.sizes.to)) {
//                         settings.translateY = [
//                             translateY.sizes.from || 0,
//                             translateY.size || translateY.sizes.to || 20
//                         ];
//                         hasEffect = true;
//                     }

//                     // Set duration/delay if specified
//                     var duration = this.getFxVal('translate_duration');
//                     if (duration && duration.size) {
//                         settings.duration = duration.size;
//                     }

//                     var delay = this.getFxVal('translate_delay');
//                     if (delay && delay.size) {
//                         settings.delay = delay.size;
//                     }
//                 }

//                 // Only create animation if effects are enabled
//                 if (hasEffect) {
//                     this.$element.css('will-change', 'transform');
                    
//                     // Destroy previous animation if exists
//                     if (this.animation) {
//                         this.animation.pause();
//                         this.animation = null;
//                     }
                    
//                     // Create new animation
//                     this.animation = anime(settings);
//                 } else if (this.animation) {
//                     // Clean up if effects are disabled
//                     this.animation.pause();
//                     this.animation = null;
//                     this.$element.css('will-change', '');
//                 }
//             },

//             onElementChange: function(setting) {
//                 if (setting.indexOf('stea_floating_fx') !== -1) {
//                     this.run();
//                 }
//             }
//         });

//         // Register handler for all widgets
//         elementorFrontend.hooks.addAction('frontend/element_ready/widget', function($element) {
//             elementorFrontend.elementsHandler.addHandler(FloatingHandler, {
//                 $element: $element
//             });
//         });
//     });
// })(jQuery);






(function($) {
    'use strict';

    $(window).on('elementor/frontend/init', function() {
        
        var FloatingHandler = elementorModules.frontend.handlers.Base.extend({
            
            bindEvents: function() {
                this.run();
            },

            getDefaultSettings: function() {
                return {
                    targets: this.$element[0],
                    direction: 'alternate',
                    easing: 'easeInOutSine',
                    loop: true,
                    autoplay: true
                };
            },

            getFxVal: function(prop) {
                return this.getElementSettings('stea_floating_fx_' + prop);
            },

            run: function() {
                if (typeof anime === 'undefined') {
                    console.error('STEA Floating: anime.js is not loaded');
                    return;
                }

                var settings = this.getDefaultSettings();
                var hasEffect = false;

                // 1. TRANSLATE EFFECTS
                if (this.getFxVal('translate_toggle') === 'yes') {
                    hasEffect = true;
                    
                    var translateX = this.getFxVal('translate_x');
                    if (translateX && (translateX.size || translateX.sizes.to)) {
                        settings.translateX = [
                            translateX.sizes.from || 0,
                            translateX.size || translateX.sizes.to || 20
                        ];
                    }

                    var translateY = this.getFxVal('translate_y');
                    if (translateY && (translateY.size || translateY.sizes.to)) {
                        settings.translateY = [
                            translateY.sizes.from || 0,
                            translateY.size || translateY.sizes.to || 20
                        ];
                    }

                    var translateDuration = this.getFxVal('translate_duration');
                    if (translateDuration && translateDuration.size) {
                        settings.duration = translateDuration.size;
                    }

                    var translateDelay = this.getFxVal('translate_delay');
                    if (translateDelay && translateDelay.size) {
                        settings.delay = translateDelay.size;
                    }
                }

                // 2. ROTATE EFFECTS
                if (this.getFxVal('rotate_toggle') === 'yes') {
                    hasEffect = true;
                    var rotateMode = this.getFxVal('rotate_mode') || 'loose';

                    if (rotateMode === 'loose') {
                        var rotateX = this.getFxVal('rotate_x');
                        if (rotateX && (rotateX.size || rotateX.sizes.to)) {
                            settings.rotateX = [
                                rotateX.sizes.from || 0,
                                rotateX.size || rotateX.sizes.to || 30
                            ];
                        }

                        var rotateY = this.getFxVal('rotate_y');
                        if (rotateY && (rotateY.size || rotateY.sizes.to)) {
                            settings.rotateY = [
                                rotateY.sizes.from || 0,
                                rotateY.size || rotateY.sizes.to || 0
                            ];
                        }
                    }

                    var rotateZ = this.getFxVal('rotate_z');
                    if (rotateZ && (rotateZ.size || rotateZ.sizes.to)) {
                        settings.rotate = [ // Note: anime.js uses 'rotate' not 'rotateZ'
                            rotateZ.sizes.from || 0,
                            rotateZ.size || rotateZ.sizes.to || 30
                        ];
                    }

                    var rotateDuration = this.getFxVal('rotate_duration');
                    if (rotateDuration && rotateDuration.size) {
                        settings.duration = rotateDuration.size;
                    }

                    var rotateDelay = this.getFxVal('rotate_delay');
                    if (rotateDelay && rotateDelay.size) {
                        settings.delay = rotateDelay.size;
                    }
                }

                // 3. SCALE EFFECTS
                if (this.getFxVal('scale_toggle') === 'yes') {
                    hasEffect = true;
                    var scaleMode = this.getFxVal('scale_mode') || 'loose';

                    if (scaleMode === 'loose') {
                        var scaleX = this.getFxVal('scale_x');
                        if (scaleX && (scaleX.size || scaleX.sizes.to)) {
                            settings.scaleX = [
                                scaleX.sizes.from || 1,
                                scaleX.size || scaleX.sizes.to || 1.2
                            ];
                        }

                        var scaleY = this.getFxVal('scale_y');
                        if (scaleY && (scaleY.size || scaleY.sizes.to)) {
                            settings.scaleY = [
                                scaleY.sizes.from || 1,
                                scaleY.size || scaleY.sizes.to || 1
                            ];
                        }
                    }

                    var scaleZ = this.getFxVal('scale_z');
                    if (scaleZ && (scaleZ.size || scaleZ.sizes.to)) {
                        settings.scale = [
                            scaleZ.sizes.from || 1,
                            scaleZ.size || scaleZ.sizes.to || 1.2
                        ];
                    }

                    var scaleDuration = this.getFxVal('scale_duration');
                    if (scaleDuration && scaleDuration.size) {
                        settings.duration = scaleDuration.size;
                    }

                    var scaleDelay = this.getFxVal('scale_delay');
                    if (scaleDelay && scaleDelay.size) {
                        settings.delay = scaleDelay.size;
                    }
                }

                // Apply animation if any effects are enabled
                if (hasEffect) {
                    this.$element.css('will-change', 'transform');
                    
                    // Destroy previous animation if exists
                    if (this.animation) {
                        this.animation.pause();
                        this.animation = null;
                    }
                    
                    // Create new animation
                    console.log('STEA Floating: Creating animation with settings', settings);
                    this.animation = anime(settings);
                } else if (this.animation) {
                    // Clean up if effects are disabled
                    this.animation.pause();
                    this.animation = null;
                    this.$element.css('will-change', '');
                }
            },

            onElementChange: function(setting) {
                if (setting.indexOf('stea_floating_fx') !== -1) {
                    this.run();
                }
            }
        });

        // Register handler for all widgets
        elementorFrontend.hooks.addAction('frontend/element_ready/widget', function($element) {
            elementorFrontend.elementsHandler.addHandler(FloatingHandler, {
                $element: $element
            });
        });
    });
})(jQuery);