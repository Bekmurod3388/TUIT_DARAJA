import re

with open('storage/framework/views/e2d7a955e16ec64457ba81432b525c6c.php', 'r') as f:
    content = f.read()

# Restore standard blade syntax
content = re.sub(r'<\?php echo e\((.*?)\); \?>', r'{{ \1 }}', content)
content = re.sub(r'<\?php echo \$\__env->make\(\'(.*?)\'.*?\)->render\(\); \?>', r'@include(\'\1\')', content)
content = re.sub(r'<\?php echo csrf_field\(\); \?>', r'@csrf', content)

# Restore structures
content = re.sub(r'<\?php if\((.*?)\): \?>', r'@if(\1)', content)
content = re.sub(r'<\?php elseif\((.*?)\): \?>', r'@elseif(\1)', content)
content = re.sub(r'<\?php else: \?>', r'@else', content)
content = re.sub(r'<\?php endif; \?>', r'@endif', content)

# Remove Laravel loop tracking
content = re.sub(r'<\?php \$\__empty_1 = true; \$\__currentLoopData = (.*?); \$\__env->addLoop\(\$\__currentLoopData\); foreach\(\$\__currentLoopData as ([^:]+)\): \$\__env->incrementLoopIndices\(\); \$loop = \$\__env->getLastLoop\(\); \$\__empty_1 = false; \?>', r'@forelse(\1 as \2)', content)
content = re.sub(r'<\?php \$\__currentLoopData = (.*?); \$\__env->addLoop\(\$\__currentLoopData\); foreach\(\$\__currentLoopData as ([^:]+)\): \$\__env->incrementLoopIndices\(\); \$loop = \$\__env->getLastLoop\(\); \?>', r'@foreach(\1 as \2)', content)
content = re.sub(r'<\?php endforeach; \$\__env->popLoop\(\); \$loop = \$\__env->getLastLoop\(\); if \(\$\__empty_1\): \?>', r'@empty', content)
content = re.sub(r'<\?php endforeach; \$\__env->popLoop\(\); \$loop = \$\__env->getLastLoop\(\); \?>', r'@endforeach', content)
content = re.sub(r'<\?php endforelse; \?>', r'@endforelse', content) # forelse closing if empty was used? Laravel usually uses endif for forelse.
content = re.sub(r'<\?php endif; \?>', r'@endif', content) # re-run just in case

# Fix JSON encoding
content = re.sub(r'<\?php echo json_encode\((.*?), 512\) \?>', r'@json(\1)', content)

# Fix custom php blocks
content = re.sub(r'<\?php\s*(.*?)(\s*)\?>', r'@php \1 \2@endphp', content, flags=re.DOTALL)

with open('resources/views/my-applications.blade.php', 'w') as f:
    f.write(content)
print("Restored!")
