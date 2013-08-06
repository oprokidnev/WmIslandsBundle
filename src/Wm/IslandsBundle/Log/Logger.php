<?php

namespace Wm\IslandsBundle\Log;

/**
 * Description of Logger
 *
 * @author oprokidnev
 */
class Logger
{

    const ERROR_MESSAGE_TEMPLATE   = "[%time%] Ошибка (%formname%): %errors% \r\n";
    const SUCCESS_MESSAGE_TEMPLATE = "[%time%] Операция для формы %formname% завершилась успехом \r\n";

    protected $successFilename;
    protected $errorFilename;

    public function __construct($successFilename, $errorFilename)
    {
        $this->successFilename = $successFilename;
        $this->errorFilename   = $errorFilename;
    }

    public function save($formname, $success, $errors)
    {
        if ($success) {
            $message = self::SUCCESS_MESSAGE_TEMPLATE;
            $message = str_replace('%time%', (new \DateTime())->format(\DateTime::RFC3339), $message);
            $message = str_replace('%formname%', $formname, $message);
            $message = str_replace('%errors%', implode(',', $errors), $message);
            file_put_contents($this->successFilename, $message, FILE_APPEND);
        } else {
            $message = self::ERROR_MESSAGE_TEMPLATE;
            $message = str_replace('%time%', (new \DateTime())->format(\DateTime::RFC3339), $message);
            $message = str_replace('%formname%', $formname, $message);
            $message = str_replace('%errors%', implode(',', $errors), $message);
            file_put_contents($this->errorFilename, $message, FILE_APPEND);
        }
    }

}

?>
