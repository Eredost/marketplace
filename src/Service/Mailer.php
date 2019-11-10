<?php


namespace App\Service;


class Mailer
{
    /** @var \Swift_Mailer */
    private $mailer;

    /** @var string */
    private $sender;

    /**
     * Mailer constructor.
     *
     * @param \Swift_Mailer $mailer
     * @param string        $sender
     */
    public function __construct(\Swift_Mailer $mailer, string $sender)
    {
        $this->mailer = $mailer;
        $this->sender = $sender;
    }

    /**
     * Generates an email from the information sent as parameter
     *
     * $mailer->sendEmail(
     *     'michael.coutin62@gmail.com',
     *     'Bienvenu sur Cocorico World !',
     *     $this->renderView(
     *         'mail/registration.html.twig',
     *         ['name' => 'Mathieu'],
     *         'text/html'
     * );
     *
     * @param string $consignee The consignee email address
     * @param string $header The subject of the email
     * @param string $content The content of the email
     *
     * @return bool
     */
    public function sendEmail(string $consignee, string $header, string $content)
    {
        /** @var \Swift_Message $email */
        $email = new \Swift_Message($header);

        $email->setFrom($this->sender)
            ->setTo($consignee)
            ->setBody($content)
        ;

        return (bool) $this->mailer->send($email);
    }
}
