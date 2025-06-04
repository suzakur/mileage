import puppeteer from 'puppeteer';

(async () => {
    const browser = await puppeteer.launch({ headless: "new" });
    const page = await browser.newPage();

    await page.goto('https://www.bca.co.id/id/promo-bca', { waitUntil: 'networkidle2' });

    // Extract promo details
    const promos = await page.evaluate(() => {
        let items = [];
        document.querySelectorAll('.infinite-promo .card').forEach(card => {
            let title = card.querySelector('.promo-title')?.innerText.trim() || 'No Title';
            let excerpt = card.querySelector('.promo-desc')?.innerText.trim() || 'No Description';
            let link = card.querySelector('a')?.href || '#';
            let image = card.querySelector('img')?.src || '';

            items.push({ title, excerpt, link, image });
        });
        return items;
    });

    console.log(JSON.stringify(promos, null, 2)); // Output JSON
    await browser.close();
})();
