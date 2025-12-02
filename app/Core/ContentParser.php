<?php

namespace App\Core;

class ContentParser
{
    public function parseMarkdownWithFrontMatter($content)
    {
        $pattern = '/^---\s*\r?\n(.*?)\r?\n---\s*\r?\n(.*)$/s';
        
        if (preg_match($pattern, $content, $matches)) {
            $frontMatter = $this->parseYaml($matches[1]);
            $body = trim($matches[2]);
            
            if (preg_match('/<[a-z][\s\S]*>/i', $body)) {
                return [
                    'meta' => $frontMatter,
                    'content' => $body,
                    'raw_content' => $body
                ];
            } else {
                return [
                    'meta' => $frontMatter,
                    'content' => $this->parseMarkdown($body),
                    'raw_content' => $body
                ];
            }
        }
        
        if (preg_match('/<[a-z][\s\S]*>/i', $content)) {
            return [
                'meta' => ['title' => 'Страница'],
                'content' => $content,
                'raw_content' => $content
            ];
        }
        
        return [
            'meta' => ['title' => 'Новая страница'],
            'content' => $this->parseMarkdown($content),
            'raw_content' => $content
        ];
    }
    
    public function calculateReadTime($content)
    {
        $text = strip_tags($content ?? '');
        $wordCount = str_word_count($text);
        $minutes = ceil($wordCount / 200);
        return max(1, $minutes);
    }
    
    private function parseYaml($yaml)
    {
        $lines = explode("\n", trim($yaml));
        $data = [];
        
        foreach ($lines as $line) {
            $line = trim($line);
            if (strpos($line, ':') !== false) {
                list($key, $value) = explode(':', $line, 2);
                $key = trim($key);
                $value = trim($value);
                
                if (preg_match('/^["\'](.*)["\']$/', $value, $matches)) {
                    $value = $matches[1];
                }
                
                $data[$key] = $value;
            }
        }
        
        return $data;
    }

    private function parseMarkdown($text)
    {

        $text = $this->parseCodeBlocks($text);


        $rules = [
            '/`([^`]+)`/' => '<code>$1</code>',
            '/^# (.*?)$/m' => '<h1>$1</h1>',
            '/^## (.*?)$/m' => '<h2>$1</h2>',
            '/^### (.*?)$/m' => '<h3>$1</h3>',
            '/\*\*(.*?)\*\*/' => '<strong>$1</strong>',
            '/\*(.*?)\*/' => '<em>$1</em>',
            '/^\s*-\s+(.*?)$/m' => '<li>$1</li>',
            '/^\s*\d+\.\s+(.*?)$/m' => '<li>$1</li>',
            '/!\[([^\]]*)\]\(([^)]+)\)/' => '<img src="$2" alt="$1" style="max-width: 100%; height: auto; border-radius: 8px; margin: 1rem 0;">',
            '/\[(.*?)\]\((.*?)\)/' => '<a href="$2" target="_blank">$1</a>',
            '/^\s*>\s+(.*?)$/m' => '<blockquote>$1</blockquote>',
        ];

        $html = $text;
        foreach ($rules as $pattern => $replacement) {
            $html = preg_replace($pattern, $replacement, $html);
        }


        $html = preg_replace('/(<li>.*<\/li>)/s', '<ul>$1</ul>', $html);
        $html = preg_replace('/\n\s*\n/', '</p><p>', $html);
        $html = '<p>' . $html . '</p>';
        $html = str_replace('<p><ul>', '<ul>', $html);
        $html = str_replace('</ul></p>', '</ul>', $html);
        $html = str_replace('<p><li>', '<li>', $html);
        $html = str_replace('</li></p>', '</li>', $html);

        return $html;
    }

    private function parseCodeBlocks($text)
    {
        // Разделяем текст на строки
        $lines = explode("\n", $text);
        $result = [];
        $inCodeBlock = false;
        $currentCode = [];
        $language = '';

        foreach ($lines as $line) {

            if (preg_match('/^```(\w*)$/', trim($line), $matches)) {
                if (!$inCodeBlock) {
                    // Начало блока кода
                    $inCodeBlock = true;
                    $language = $matches[1] ?? '';
                    $currentCode = [];
                } else {

                    $inCodeBlock = false;
                    $codeContent = implode("\n", $currentCode);
                    $escapedCode = htmlspecialchars($codeContent);
                    $result[] = '<pre><code class="language-' . $language . '">' . $escapedCode . '</code></pre>';
                }
                continue;
            }

            if ($inCodeBlock) {
                $currentCode[] = $line;
            } else {
                $result[] = $line;
            }
        }


        if ($inCodeBlock && !empty($currentCode)) {
            $codeContent = implode("\n", $currentCode);
            $escapedCode = htmlspecialchars($codeContent);
            $result[] = '<pre><code class="language-' . $language . '">' . $escapedCode . '</code></pre>';
        }

        return implode("\n", $result);
    }

}