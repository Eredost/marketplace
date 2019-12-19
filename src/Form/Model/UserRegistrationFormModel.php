<?php


namespace App\Form\Model;


use App\Validator\UniqueUser;
use Symfony\Component\Validator\Constraints as Assert;

class UserRegistrationFormModel
{
    /**
     * @Assert\NotBlank(
     *     message="Veuillez entrer un email"
     * )
     * @Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas valide."
     * )
     * @Assert\Length(
     *      min = 6,
     *      max = 180,
     *      minMessage = "Votre email doit comporter {{ limit }} caractères au minimum",
     *      maxMessage = "Votre email doit comporter {{ limit }} caractères au maximum"
     * )
     * @UniqueUser()
     */
    public $email;

    /**
     * @Assert\NotBlank(
     *     message="Veuillez entrer un mot de passe"
     * )
     * @Assert\Length(
     *      min = 6,
     *      max = 30,
     *      minMessage = "Votre mot de passe doit comporter {{ limit }} caractères au minimum",
     *      maxMessage = "Votre mot de passe doit comporter {{ limit }} caractères au maximum"
     * )
     */
    public $plainPassword;

    /**
     * @Assert\IsTrue(
     *     message="Vous devez accepter les conditions générales d'utilisation"
     * )
     */
    public $agreedTerms;
}