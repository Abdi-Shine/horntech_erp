import fs from 'fs';
const path = 'd:\\Bilkheyr\\resources\\views\\frontend\\parties\\customer.blade.php';
const content = fs.readFileSync(path, 'utf8');

const directives = [
    '@if', '@endif',
    '@foreach', '@endforeach',
    '@forelse', '@empty', '@endforelse',
    '@for', '@endfor',
    '@while', '@endwhile',
    '@php', '@endphp',
    '@section', '@endsection',
    '@push', '@endpush',
    '@extends'
];

directives.forEach(d => {
    let count = 0;
    let pos = content.indexOf(d);
    while (pos !== -1) {
        count++;
        pos = content.indexOf(d, pos + d.length);
    }
    console.log(`${d}: ${count}`);
});
