<?php
class Retailon_Bulkimageupload_Block_Adminhtml_Upload extends Mage_Core_Block_Template
{
        public function extract($zipname)
    {
        $zip = new ZipArchive;
        if($zip->open($zipname))
        {
            for($i=0; $i<$zip->numFiles; $i++)
            {
                $zip->getNameIndex($i);
            }
            if($zip->extractTo(MAGENTO_ROOT.'/media/import/')){ echo '<p>FILE EXTRACTED</p>'; }else{ echo '<p>ERROR IN FILE EXTRACTING!</p>'; }
            $zip->close();
        }
        else
        { echo 'Error reading Zip Archive'; }
    }
}