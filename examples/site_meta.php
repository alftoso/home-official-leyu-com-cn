<?php
/**
 * Site metadata configuration with description generation utility
 */

class SiteMeta {
    private array $metadata = [];

    public function __construct(array $config = []) {
        $this->metadata = $config ?: $this->getDefaultMeta();
    }

    private function getDefaultMeta(): array {
        return [
            'title'       => '乐鱼体育',
            'domain'      => 'home-official-leyu.com.cn',
            'description' => '乐鱼体育官方平台',
            'keywords'    => ['乐鱼体育', '体育赛事', '在线娱乐'],
            'language'    => 'zh-CN',
            'author'      => 'Admin',
            'version'     => '1.0.0'
        ];
    }

    public function setMeta(string $key, $value): void {
        $this->metadata[$key] = $value;
    }

    public function getMeta(string $key, $default = null) {
        return $this->metadata[$key] ?? $default;
    }

    public function generateShortDescription(int $maxLength = 120): string {
        $parts = [];

        $title = $this->getMeta('title', '');
        if ($title) {
            $parts[] = $title;
        }

        $domain = $this->getMeta('domain', '');
        if ($domain) {
            $parts[] = $domain;
        }

        $keywords = $this->getMeta('keywords', []);
        if (!empty($keywords)) {
            $parts[] = '关键词: ' . implode(', ', array_slice($keywords, 0, 3));
        }

        $desc = $this->getMeta('description', '');
        if ($desc) {
            $parts[] = $desc;
        }

        $raw = implode(' | ', $parts);

        if (mb_strlen($raw) > $maxLength) {
            $raw = mb_substr($raw, 0, $maxLength - 3) . '...';
        }

        return htmlspecialchars($raw, ENT_QUOTES, 'UTF-8');
    }

    public function toArray(): array {
        return $this->metadata;
    }
}

// --- Example usage ---

$config = [
    'title'       => '乐鱼体育',
    'domain'      => 'home-official-leyu.com.cn',
    'description' => '乐鱼体育——专业体育赛事资讯与娱乐平台',
    'keywords'    => ['乐鱼体育', '体育资讯', '赛事直播', '娱乐'],
    'language'    => 'zh-CN',
    'author'      => 'Leyu Team',
    'version'     => '2.3.1'
];

$meta = new SiteMeta($config);

echo $meta->generateShortDescription(100) . "\n";

// Override and test
$meta->setMeta('title', '乐鱼体育官网');
echo $meta->generateShortDescription(80) . "\n";