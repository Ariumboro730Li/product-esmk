function dateLanguageFormat(date) {
    if (date.includes('/') && /^\d{2}\/\d{2}\/\d{4}$/.test(date)) {
        const [day, month, year] = date.split('/');

        date = `${year}-${month}-${day}`;
    }

    const options = {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    };

    return new Date(date).toLocaleDateString('id-ID', options);
}

function timestampId(date) {
    const optionsDate = {
        day: 'numeric',
        month: 'long',
        year: 'numeric'
    };

    const optionsTime = {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    };

    const dateObj = new Date(date);

    if (dateObj.getHours() > 0 || dateObj.getMinutes() > 0 || dateObj.getSeconds() > 0) {
        return dateObj.toLocaleDateString('id-ID', optionsDate) + ', ' + dateObj.toLocaleTimeString('id-ID', optionsTime);
    } else {
        return dateObj.toLocaleDateString('id-ID', optionsDate);
    }
}

function formatTime(dateTime) {
    let date = new Date(dateTime);

    let hours = date.getHours().toString().padStart(2, '0');
    let minutes = date.getMinutes().toString().padStart(2, '0');

    return `${hours}:${minutes}`;
}
