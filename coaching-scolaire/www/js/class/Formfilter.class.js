"use strict";

let FormFilter = function ($form) {
    this.$form = $form;
    this.errors = false; // au départ, on démarre sous l'hypothèse qu'il n'y a pas d'erreurs
};


FormFilter.prototype.checkLength = function () {
    let minLength, maxLength, length;

    $('[data-min]').each(function(key, input) {
        minLength = parseInt($(input).data('min'));
        length = $(input).val().length;

        //on vérifie que le champ n'est pas vide et ue la longueur est conforme
        if(length && length < minLength) {
            this.errors = true;
            $(input).next().html('Ce champ doit faire un minimum de ' + minLength + ' caractère(s)');
        }
    }.bind(this));

    $('[data-max]').each(function(key, input) {
        maxLength = parseInt($(input).data('max'));
        length = $(input).val().length;

        //on vérifie que le champ n'est pas vide et ue la longueur est conforme
        if(length && legnth > maxLength) {
            this.errors = true;
            $(input).next().html('Ce champ doit faire un maximum de ' + maxLength + ' caractère(s)');
        }
    }.bind(this));
};


FormFilter.prototype.checkType = function() {
    let value, regexp;

    $('[data-type]').each(function (key, input) {
        value = $(input).val();

        // On passe au each suivant (càd au data-required en-dessous) si le champ est vide
        if (!value)
            return;

        switch ($(input).data('type')) {
            case 'positive-integer':
                if (isNaN(value) || value < 0 || value % 1 !== 0) {
                    this.errors = true;
                    $(input).next().html('Ce champ doit être un entier positif');
                }
                break;
            case 'email':
                regexp = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/

                if (!value.match(regexp)) {
                    this.errors = true;
                    $(input).next().html('Ce champ doit être au format email');
                }
                break;
        }
    }.bind(this));
};


FormFilter.prototype.checkRequired = function () {
    $('[data-required]').each(function(key, input) {

        if ($(input).val().length === 0) {
            this.errors = true;
            $(input).next().html('Ce champ est obligatoire');
        }
    }.bind(this));
};



FormFilter.prototype.checkForms = function () {
    // on met les erreurs à 0, càd qu'on repart d'une situation initiale sans erreurs
    this.$form.find('p').html('&nbsp;');  // 'p' --> paragraphe apparant à chaque li, comportant la classe "error", signalant et affichant l'erreur, s'il y en a une.
    this.errors = false;

    //data-required
    this.checkRequired();

    //data-length
    this.checkLength();

    //data-type (e-mail. phone number, ...)
    this.checkType();

    if (this.errors) {
        //this.displayErrors();
        event.preventDefault();
    }

};



// activation du filter une fois le formulaire envoyé (submit), ce qui va ensuite enclencher la fonction checkForms (qui va être développée juste au-dessus)
FormFilter.prototype.run = function () {
    console.log("checking");
    this.$form.submit(
        function (){
            this.checkForms();
        }.bind(this)
    );
};