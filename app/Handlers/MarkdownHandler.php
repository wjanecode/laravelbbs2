<?php
/**
 *
 * @author woojuan
 * @email woojuan163@163.com
 * @copyright GPL
 * @version
 */

namespace App\Handlers;

use Parsedown;
use League\HTMLToMarkdown\HtmlConverter;

/*
 * markdown处理器
 */
class MarkdownHandler
{

    protected $htmlConverter;//html转换器
    protected $markdownConverter;//markdown转换器

    public function __construct(  ) {
        $this->htmlConverter = new HtmlConverter();
        $this->markdownConverter = new Parsedown();
    }

    /**
     *  html转换Markdown
     * @param $html
     *
     * @return string
     */
    public function convertHtmlToMarkdown( $html )
    {
        return $this->htmlConverter->convert($html);
    }

    /**
     * Markdown转html
     * @param $markdown
     *
     * @return string
     */
    public function convertMarkdownToHtml($markdown)
    {
        return $this->markdownConverter->setBreaksEnabled(true)->text($markdown);
    }

}
