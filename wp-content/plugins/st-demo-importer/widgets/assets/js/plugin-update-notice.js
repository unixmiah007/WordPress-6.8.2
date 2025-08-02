jQuery( document ).ready( function() {

    if ( jQuery('#stdi-notice-confetti').length ) {
        const stConfetti = confetti.create( document.getElementById('stdi-notice-confetti'), {
            resize: true
        });

        setTimeout( function () {
            stConfetti( {
                particleCount: 150,
                origin: { x: 1, y: 2 },
                gravity: 0.3,
                spread: 50,
                ticks: 150,
                angle: 120,
                startVelocity: 60,
                colors: [
                    '#0e6ef1',
                    '#f5b800',
                    '#ff344c',
                    '#98e027',
                    '#9900f1',
                ],
            } );
        }, 500 );

        setTimeout( function () {
            stConfetti( {
                particleCount: 150,
                origin: { x: 0, y: 2 },
                gravity: 0.3,
                spread: 50,
                ticks: 200,
                angle: 60,
                startVelocity: 60,
                colors: [
                    '#0e6ef1',
                    '#f5b800',
                    '#ff344c',
                    '#98e027',
                    '#9900f1',
                ],
            } );
        }, 900 );
    }
});