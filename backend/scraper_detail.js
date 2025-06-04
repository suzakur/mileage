const puppeteer = require('puppeteer');

(async () => {
    const url = process.argv[2]; // Get URL from Laravel
    if (!url) {
        console.log('No URL provided.');
        process.exit(1);
    }

    const browser = await puppeteer.launch({ headless: "new" });
    const page = await browser.newPage();

    await page.goto(url, { waitUntil: 'networkidle2' });

    // Extract full promo content
    const content = await page.evaluate(() => {
        return document.querySelector('.promo-content')?.innerText.trim() || 'No detailed content available.';
    });

    console.log(content);
    await browser.close();
})();
