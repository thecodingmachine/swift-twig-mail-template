<?php

namespace TheCodingMachine\Mail\Template;

class MissingBlockException extends \RuntimeException implements MailTemplateException
{
    /**
     * @param array $blockNames
     *
     * @return MissingBlockException
     */
    public static function missingBlock(array $blockNames):MissingBlockException
    {
        $blocksName = implode(',', $blockNames);
        $errorMsg = ($blocksName === '') ? 'No blocks found.' : 'Blocks found '.$blocksName.'.';

        return new self('Your template needs a subject block and a body_html block.'.$errorMsg);
    }
}
