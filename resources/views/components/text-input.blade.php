@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-brand-border focus:border-primary focus:ring-primary rounded-md shadow-sm text-brand-text']) }}>
