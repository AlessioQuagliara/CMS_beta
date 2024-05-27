<?php
require('conn.php');

function getMarketingToolId($conn, $toolName) {
    $stmt = $conn->prepare("SELECT tool_id FROM marketing_tools WHERE tool = ?");
    $stmt->bind_param("s", $toolName);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    return $row['tool_id'];
}

$googleAnalyticsId = getMarketingToolId($conn, 'Google Analytics');
$googleAdsId = getMarketingToolId($conn, 'Google Tag Manager');
$facebookPixelId = getMarketingToolId($conn, 'Facebook Pixel');
?>

<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo htmlspecialchars($googleAnalyticsId); ?>"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());
    gtag('config', '<?php echo htmlspecialchars($googleAnalyticsId); ?>');
</script>

<!-- Google Ads Conversion Tracking -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo htmlspecialchars($googleAdsId); ?>"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());
    gtag('config', '<?php echo htmlspecialchars($googleAdsId); ?>');
</script>

<!-- Facebook Pixel -->
<script>
    !function(f,b,e,v,n,t,s) {
        if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '<?php echo htmlspecialchars($facebookPixelId); ?>');
    fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=<?php echo htmlspecialchars($facebookPixelId); ?>&ev=PageView&noscript=1"
/></noscript>