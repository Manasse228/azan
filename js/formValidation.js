$(document).ready(function () {

    $('#formPub').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            nomEve: {
                validators: {
                    notEmpty: {
                        message: "Nom de l'évènement requis"
                    },
                    stringLength: {
                        max: 80,
                        //min: 10,
                        message: 'Le nom doit avoir au maximum 75 caracteres'
                    },
                    remote: {
                        message: "Ce nom d' évènement est déjà utilisé pour ce même lieu",
                        url: 'ajax/verif.php',
                        data: function (validator) {
                            return {
                                lieuEve: $('input[name="lieuEve"]').val(),
                                nomEve: $('input[name="nomEve"]').val()
                            };
                        },
                        type: 'POST',
                    },
                }
            },
            lieuEve: {
                validators: {
                    notEmpty: {
                        message: "Lieu d'évènement requis"
                    },

                }
            },
            prixEve: {
                validators: {
                    notEmpty: {
                        message: "Renseigner le prix"
                    },
                    numeric: {
                        message: 'Renseigner le prix en chiffre',
                        // The default separators
                        thousandsSeparator: '',
                        decimalSeparator: ','
                    }
                }
            },
            dateMiseEnLigneEve: {
                icon: 'false',
                validators: {
                    notEmpty: {
                        message: 'Renseigner la date de la mise en ligne'
                    },
                    date: {
                        format: 'DD-MM-YYYY',
                        message: 'Date invalide'
                    }
                }
            },
            datedebutEve: {
                icon: 'false',
                validators: {
                    notEmpty: {
                        message: 'Renseigner la date de début'
                    },
                    date: {
                        format: 'DD-MM-YYYY h:m',
                        message: 'Date invalide'
                    }
                }
            },
            datefinEve: {
                icon: 'false',
                validators: {
                    notEmpty: {
                        message: 'Renseigner la date de fin'
                    },
                    date: {
                        format: 'DD-MM-YYYY h:m',
                        message: 'Date invalide'
                    }
                }
            },
            contactEve: {
                validators: {
                    notEmpty: {
                        message: "Renseigner un contact par exemple un numero de telephone"
                    }
                }
            },
            descriptionEve: {
                validators: {
                    notEmpty: {
                        message: "Décrivez nous au moins votre évènement"
                    },
                    stringLength: {
                        min: 50,
                        message: 'La description doit comporter au moins 50 caractères'
                    }
                }
            },
            type: {
                icon: 'false',
                validators: {
                    notEmpty: {
                        message: "Selectionner un type d'événement"
                    }
                }
            },


        }
    });


    $('#inscription_form').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            pseudo: {
                validators: {
                    notEmpty: {
                        message: "Le pseudo est obligatoire"
                    },
                    stringLength: {
                        max: 80,
                        //min: 10,
                        message: 'Le pseudo doit avoir au maximum 80 caracteres'
                    },
                    remote: {
                        message: 'Ce pseudo est déja utilisé',
                        url: 'ajax/verif.php',
                        data: {
                            type: 'pseudo'
                        },
                        type: 'POST'
                    },
                }
            },
            email: {
                verbose: false,
                validators: {
                    notEmpty: {
                        message: 'Adresse email requise'
                    },
                    emailAddress: {
                        message: 'Adresse email invalide'
                    },
                    stringLength: {
                        max: 512,
                        message: "L' adresse email ne peux pas avoir 512 characters"
                    },
                    remote: {
                        type: 'GET',
                        url: 'https://api.mailgun.net/v2/address/validate?callback=?',
                        crossDomain: true,
                        name: 'address',
                        data: {
                            api_key: 'pubkey-36df9b06989807c71f588b584a92950a'
                        },
                        dataType: 'jsonp',
                        validKey: 'is_valid',
                        message: 'Adresse email incorrecte'
                    },
                    remote: {
                        message: 'Cette adresse email est déjà utilisée',
                        url: 'ajax/verif.php',
                        data: {
                            type: 'email'
                        },
                        type: 'POST'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: "Mot de passe obligatoire"
                    },
                    callback: {
                        callback: function (value, validator, $field) {
                            console.log('putaon');
                            var password = $field.val();
                            if (password == '') {
                                return true;
                            }

                            var result = zxcvbn(password),
                                score = result.score,
                                message = result.feedback.warning || 'Faible';

                            // Update the progress bar width and add alert class
                            var $bar = $('#strengthBar');
                            switch (score) {
                                case 0:
                                    $bar.attr('class', 'progress-bar progress-bar-danger')
                                        .css('width', '1%');
                                    break;
                                case 1:
                                    $bar.attr('class', 'progress-bar progress-bar-danger')
                                        .css('width', '25%');
                                    break;
                                case 2:
                                    $bar.attr('class', 'progress-bar progress-bar-danger')
                                        .css('width', '50%');
                                    break;
                                case 3:
                                    $bar.attr('class', 'progress-bar progress-bar-warning')
                                        .css('width', '75%');
                                    break;
                                case 4:
                                    $bar.attr('class', 'progress-bar progress-bar-success')
                                        .css('width', '100%');
                                    break;
                            }

                            // We will treat the password as an invalid one if the score is less than 3
                            if (score < 3) {
                                return {
                                    valid: false,
                                    message: message
                                }
                            }

                            return true;
                        }
                    }
                }
            },
            password2: {
                validators: {
                    notEmpty: {
                        message: "Mot de passe obligatoire"
                    },
                    callback: {
                        callback: function (value, validator, $field) {
                            var password = $field.val();
                            if (password == '') {
                                return true;
                            }

                            var result = zxcvbn(password),
                                score = result.score,
                                message = result.feedback.warning || 'Faible';

                            // Update the progress bar width and add alert class
                            var $bar = $('#strengthBar2');
                            switch (score) {
                                case 0:
                                    $bar.attr('class', 'progress-bar progress-bar-danger')
                                        .css('width', '1%');
                                    break;
                                case 1:
                                    $bar.attr('class', 'progress-bar progress-bar-danger')
                                        .css('width', '25%');
                                    break;
                                case 2:
                                    $bar.attr('class', 'progress-bar progress-bar-danger')
                                        .css('width', '50%');
                                    break;
                                case 3:
                                    $bar.attr('class', 'progress-bar progress-bar-warning')
                                        .css('width', '75%');
                                    break;
                                case 4:
                                    $bar.attr('class', 'progress-bar progress-bar-success')
                                        .css('width', '100%');
                                    break;
                            }

                            // We will treat the password as an invalid one if the score is less than 3
                            if (score < 3) {
                                return {
                                    valid: false,
                                    message: message
                                }
                            }

                            return true;
                        }
                    },
                    identical: {
                        field: 'password',
                        message: 'Les deux mots de passe ne sont pas identiques'
                    }
                }
            }

        }
    });

    $('#update_form').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            pseudo: {
                validators: {
                    notEmpty: {
                        message: "Le pseudo est obligatoire"
                    },
                    stringLength: {
                        max: 80,
                        message: 'Le pseudo doit avoir au maximum 80 caracteres'
                    },
                    remote: {
                        message: 'Ce pseudo est déja utilisé',
                        url: 'ajax/verif.php',
                        data: {
                            type: 'pseudo'
                        },
                        type: 'POST'
                    }
                }
            }
        }
    });

    $('#recuperation_password').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            emailVerif: {
                validators: {
                    notEmpty: {
                        message: "Adresse email obligatoire"
                    },
                    emailAddress: {
                        message: 'Adresse email invalide'
                    },
                    stringLength: {
                        max: 512,
                        message: "L' adresse email ne peux pas avoir 512 characters"
                    },
                    remote: {
                        type: 'GET',
                        url: 'https://api.mailgun.net/v2/address/validate?callback=?',
                        crossDomain: true,
                        name: 'address',
                        data: {
                            api_key: 'pubkey-36df9b06989807c71f588b584a92950a'
                        },
                        dataType: 'jsonp',
                        validKey: 'is_valid',
                        message: 'Adresse email incorrecte'
                    },
                    remote: {
                        message: 'Pas de compte trouvé pour cette adresse email.',
                        url: 'ajax/verif.php',
                        data: {
                            type: 'verifEmail'
                        },
                        type: 'POST'
                    }
                }
            }
        }
    });


    $('#login_form').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            login: {
                icon: 'false',
                validators: {
                    notEmpty: {
                        message: "Renseigner ce champ"
                    }
                },

            },
            password: {
                icon: 'false',
                validators: {
                    notEmpty: {
                        message: "Mot de passe obligatoire"
                    }
                },
            }
        }
    });


    $('#contactForm').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        addOns: {
            reCaptcha2: {
                element: 'captchaContainer',
                theme: 'light',
                siteKey: '6LcdISYTAAAAAIiPl0FhhsRQlyRWHqTkPxh1LDnl',
                timeout: 120,
                message: 'Le captcha est invalide'
            }
        },
        fields: {
            name: {
                validators: {
                    notEmpty: {
                        message: "Votre nom nous interesse"
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: "Votre adresse email pour avoir réponse de ce que vous voulez"
                    }
                }
            },
            message: {
                validators: {
                    notEmpty: {
                        message: "Rédiger votre message"
                    },
                    stringLength: {
                        min: 20,
                        message: 'Le message doit contenir au minimum 20 caracteres'
                    }
                }
            }
        }
    });


    $('#formPubSuite').formValidation({
        framework: 'bootstrap',
        icon: {
            valid: 'glyphicon glyphicon-ok',
            invalid: 'glyphicon glyphicon-remove',
            validating: 'glyphicon glyphicon-refresh'
        },
        fields: {
            'file_rep[]': {
                validators: {
                    notEmpty: {
                        message: 'Choisissez une image de couverture'
                    },
                    file: {
                        maxSize: 5 * 1024 * 1024,
                        message: 'Votre fichier ne doit pas dépasser 5MB'
                    }
                }
            },
            'file_couv[]': {
                validators: {
                    notEmpty: {
                        message: 'Fournissez au moins une image représentative'
                    },
                    file: {
                        //extension: 'jpeg,jpg,png',
                        //type: 'image/jpeg,image/png',
                        maxSize: 5 * 1024 * 1024,
                        message: 'Votre fichier ne doit pas dépasser 5MB'
                    }
                }
            }
        }

    });


});


