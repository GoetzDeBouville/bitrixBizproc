<?
$rootActivity = $this->GetRootActivity();
$folderId = $rootActivity->GetVariable("str");

use Bitrix\Disk\Folder;
use Bitrix\Disk\Driver;
use Bitrix\Main\Loader;

if (!Loader::includeModule('disk')) {
    $this->SetVariable("str", '');
    return;
}

$folder = Folder::getById($folderId);

if ($folder) {
    $urlManager = Driver::getInstance()->getUrlManager();
    $externalLink = $folder->addExternalLink([
        'CREATED_BY' => $folder->getCreatedBy(),
        'TYPE' => \Bitrix\Disk\Internals\ExternalLinkTable::TYPE_MANUAL,
    ]);

    if ($externalLink) {
        $externalLinkUrl = $urlManager->getShortUrlExternalLink([
            'hash' => $externalLink->getHash(),
            'action' => 'default',
        ], true);
        
        $this->SetVariable("str", $externalLinkUrl);
    } else {
        $this->SetVariable("str", '');
    }
} else {
    $this->SetVariable("str", '');
}