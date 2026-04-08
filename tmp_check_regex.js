import fs from 'fs';
const path = 'd:\\Bilkheyr\\resources\\views\\frontend\\parties\\supplier.blade.php';
const content = fs.readFileSync(path, 'utf8');

const regexIf = /@if\s*\(/g;
const regexEndIf = /@endif/g;

const ifMatches = content.match(regexIf) || [];
const endIfMatches = content.match(regexEndIf) || [];

console.log(`IF: ${ifMatches.length}`);
console.log(`ENDIF: ${endIfMatches.length}`);

// Check balance
if (ifMatches.length !== endIfMatches.length) {
    console.error('ERROR: Mismatched IF/ENDIF');
}

const foreach = content.match(/@foreach/g) || [];
const endforeach = content.match(/@endforeach/g) || [];
console.log(`FOREACH: ${foreach.length} / ${endforeach.length}`);

const forelse = content.match(/@forelse/g) || [];
const endforelse = content.match(/@endforelse/g) || [];
console.log(`FORELSE: ${forelse.length} / ${endforelse.length}`);
