<?php
// Client logo filenames - easy to edit by modifying this array
// Just add the filename, the shortcode will handle the full Media Library URL
$client_logos = array(
    'company_01.png',
    'company_02.png', 
    'company_03.png',
    'company_04.png',
    'company_05.png',
    'company_06.png',
    'company_07.png',
    'company_08.png'
);
?>

<section class="pces-clients py-5">
    <div class="container">
        <h2 class="text-center mb-5">Trusted by these Leading Companies</h2>
        <div class="row justify-content-center">
            <?php foreach($client_logos as $logo_filename): 
                // Generate WordPress Media Library URL programmatically
                $logo_url = pces_get_media_url($logo_filename);
                
                if ($logo_url): ?>
                    <div class="col-6 col-md-3 mb-4">
                        <div class="client-logo-wrapper text-center">
                            <img src="<?php echo esc_url($logo_url); ?>" 
                                 alt="PCES Inc Logo" 
                                 class="client-logo img-fluid">
                        </div>
                    </div>
                <?php endif; 
            endforeach; ?>
        </div>
    </div>
</section>