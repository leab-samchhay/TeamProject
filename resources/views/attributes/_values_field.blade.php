@php $vals = ($values ?? collect()); @endphp
<style>
    .av-tags {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 6px;
        border: 1px solid #e4e7ec;
        border-radius: 8px;
        padding: 8px;
        min-height: 44px;
        cursor: text;
    }

    .av-tag {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #eef3ff;
        color: #2f6bff;
        border-radius: 6px;
        padding: 3px 9px;
        font-size: 13px;
    }

    .av-tag i {
        cursor: pointer;
        color: #6b8cff;
    }

    .av-input {
        border: none;
        outline: none;
        flex: 1;
        min-width: 100px;
        font-size: 14px;
        background: transparent;
    }
</style>

<div class="av-tags" id="avTags">
    @foreach ($vals as $v)
        <span class="av-tag">{{ $v }} <i class="ti ti-x" data-x></i><input type="hidden" name="values[]"
                value="{{ $v }}"></span>
    @endforeach
    <input type="text" class="av-input" id="avInput" placeholder="Type a value & Enter (e.g. Red, S, 256GB)">
</div>
<small class="text-muted">These values appear automatically when you pick this attribute in the product builder.</small>

<script>
    (function () {
        const box = document.getElementById('avTags');
        const input = document.getElementById('avInput');
        const escAttr = (s) => String(s).replace(/"/g, '&quot;');
        const escHtml = (s) => String(s).replace(/[&<>]/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;' }[c]));

        function add(raw) {
            const v = (raw || '').trim();
            if (!v) return;
            const dupe = [...box.querySelectorAll('input[name="values[]"]')]
                .some(i => i.value.toLowerCase() === v.toLowerCase());
            if (dupe) return;
            const span = document.createElement('span');
            span.className = 'av-tag';
            span.innerHTML = `${escHtml(v)} <i class="ti ti-x" data-x></i><input type="hidden" name="values[]" value="${escAttr(v)}">`;
            box.insertBefore(span, input);
        }

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ',') {
                e.preventDefault();
                add(input.value);
                input.value = '';
            } else if (e.key === 'Backspace' && input.value === '') {
                const tags = box.querySelectorAll('.av-tag');
                if (tags.length) tags[tags.length - 1].remove();
            }
        });
        input.addEventListener('blur', () => { if (input.value.trim()) { add(input.value); input.value = ''; } });
        box.addEventListener('click', (e) => {
            if (e.target.closest('[data-x]')) e.target.closest('.av-tag').remove();
            else input.focus();
        });
    })();
</script>
