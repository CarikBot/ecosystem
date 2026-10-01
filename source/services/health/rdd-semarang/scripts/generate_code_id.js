// digunakan di n8n untuk generate code_id dari patient_name
// timestamp: {{ $now.toFormat('yyyy-MM-dd HH:mm:ss') }}

const items = $input.all();

for (const item of items) {
  const body = item.json.body;

  if (body?.patient_name) {
    const prefix = body.patient_name
      .toLowerCase()
      .replace(/\s+/g, '')
      .slice(0, 4);

    const random = Math.floor(Math.random() * 1000)
      .toString()
      .padStart(3, '0');

    body.case_id = `${prefix}${random}`;
  }
}

return items;
