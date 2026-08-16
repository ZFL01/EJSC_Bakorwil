@extends('layouts.app')

@section('title', 'Kelola Mentor - EJSC Bakorwil')

@section('content')

<style>
    /* =========================================================
       KELOLA MENTOR - TOSCA / TEAL THEME
       PRIMARY COLOR : #14B8A6
    ========================================================= */

    .mentor-page {
        position: relative;
        overflow: hidden;
        background: #f8fffd;
        min-height: 100vh;
    }


    /* =========================================================
       BACKGROUND DECORATION
    ========================================================= */

    .mentor-page::before,
    .mentor-page::after {
        content: "";
        position: absolute;
        border-radius: 50%;
        pointer-events: none;
        z-index: 0;
    }

    .mentor-page::before {
        width: 320px;
        height: 320px;
        left: -160px;
        top: 250px;
        background: rgba(20, 184, 166, 0.07);

        animation:
            mentorBubble
            8s
            ease-in-out
            infinite;
    }

    .mentor-page::after {
        width: 380px;
        height: 380px;
        right: -200px;
        bottom: 80px;
        background: rgba(20, 184, 166, 0.05);

        animation:
            mentorBubble2
            10s
            ease-in-out
            infinite;
    }

    @keyframes mentorBubble {

        0%, 100% {
            transform:
                translate(0, 0)
                scale(1);
        }

        50% {
            transform:
                translate(35px, -25px)
                scale(1.08);
        }
    }

    @keyframes mentorBubble2 {

        0%, 100% {
            transform:
                translate(0, 0);
        }

        50% {
            transform:
                translate(-30px, 25px);
        }
    }


    /* =========================================================
       HEADER
    ========================================================= */

    .mentor-header {
        position: relative;
        z-index: 2;

        background:
            linear-gradient(
                135deg,
                #ffffff,
                #f0fdfa,
                #ffffff
            );

        border-bottom:
            1px solid #d9f3ee;
    }

    .mentor-header-content {
        animation:
            mentorHeaderEnter
            0.7s
            ease-out;
    }

    @keyframes mentorHeaderEnter {

        from {
            opacity: 0;
            transform:
                translateY(20px);
        }

        to {
            opacity: 1;
            transform:
                translateY(0);
        }
    }


    /* =========================================================
       TITLE
    ========================================================= */

    .mentor-title {
        color: #163b3a;
    }

    .mentor-description {
        color: #647b79;
    }


    /* =========================================================
       ADD BUTTON
    ========================================================= */

    .mentor-add-button {

        position: relative;
        overflow: hidden;

        background:
            linear-gradient(
                135deg,
                #14b8a6,
                #0f9f91
            );

        color: white;

        box-shadow:
            0 6px 16px
            rgba(20, 184, 166, 0.20);

        transition:
            transform 0.3s ease,
            box-shadow 0.3s ease,
            background 0.3s ease;
    }

    .mentor-add-button::before {

        content: "";

        position: absolute;

        top: 0;
        left: -100%;

        width: 60%;
        height: 100%;

        background:
            linear-gradient(
                90deg,
                transparent,
                rgba(255,255,255,0.35),
                transparent
            );

        transform:
            skewX(-20deg);

        transition:
            left 0.6s ease;
    }

    .mentor-add-button:hover::before {
        left: 130%;
    }

    .mentor-add-button:hover {

        transform:
            translateY(-2px);

        background:
            linear-gradient(
                135deg,
                #0f9f91,
                #0d8f83
            );

        box-shadow:
            0 10px 24px
            rgba(20, 184, 166, 0.28);
    }


    /* =========================================================
       CONTENT SECTION
    ========================================================= */

    .mentor-content {
        position: relative;
        z-index: 2;
    }


    /* =========================================================
       SEARCH
    ========================================================= */

    .mentor-search {

        transition:
            border-color 0.3s ease,
            box-shadow 0.3s ease,
            transform 0.25s ease;
    }

    .mentor-search:focus {

        border-color:
            #14b8a6 !important;

        box-shadow:
            0 0 0 4px
            rgba(20, 184, 166, 0.12),

            0 6px 18px
            rgba(15, 118, 110, 0.06);

        transform:
            translateY(-1px);

        outline: none;
    }


    /* =========================================================
       TABLE CONTAINER
    ========================================================= */

    .mentor-table-container {

        background:
            rgba(255, 255, 255, 0.98);

        border:
            1px solid #dff2ef;

        border-radius:
            18px;

        box-shadow:
            0 6px 24px
            rgba(15, 118, 110, 0.05);

        overflow: hidden;

        animation:
            mentorTableEnter
            0.7s
            ease-out;
    }

    @keyframes mentorTableEnter {

        from {
            opacity: 0;
            transform:
                translateY(25px);
        }

        to {
            opacity: 1;
            transform:
                translateY(0);
        }
    }


    /* =========================================================
       TABLE HEADER
    ========================================================= */

    .mentor-table-head {

        background:
            #f0fdfa;

        color:
            #55716e;
    }


    /* =========================================================
       TABLE ROW
    ========================================================= */

    .mentor-row {

        transition:
            background 0.25s ease,
            transform 0.25s ease;
    }

    .mentor-row:hover {

        background:
            #f4fffd;
    }


    /* =========================================================
       AVATAR
    ========================================================= */

    .mentor-avatar {

        background:
            linear-gradient(
                135deg,
                #14b8a6,
                #0f9f91
            );

        color:
            white;

        box-shadow:
            0 7px 16px
            rgba(20, 184, 166, 0.18);

        transition:
            transform 0.3s ease,
            box-shadow 0.3s ease;
    }

    .mentor-row:hover .mentor-avatar {

        transform:
            translateY(-2px)
            scale(1.04);

        box-shadow:
            0 10px 22px
            rgba(20, 184, 166, 0.25);
    }


    /* =========================================================
       MENTOR NAME
    ========================================================= */

    .mentor-name {
        color:
            #173f3d;
    }

    .mentor-info {
        color:
            #647b79;
    }


    /* =========================================================
       BADGE BIDANG
    ========================================================= */

    .badge-teknologi {

        background:
            #ccfbf1;

        color:
            #0f766e;
    }

    .badge-bisnis {

        background:
            #d9f7f2;

        color:
            #147d75;
    }

    .badge-desain {

        background:
            #e0f7f4;

        color:
            #16756f;
    }

    .badge-pendidikan {

        background:
            #dff6f2;

        color:
            #176e68;
    }


    /* =========================================================
       ACTION BUTTON
    ========================================================= */

    .mentor-edit-button {

        color:
            #0f9f91;

        transition:
            background 0.25s ease,
            color 0.25s ease,
            transform 0.25s ease;
    }

    .mentor-edit-button:hover {

        background:
            #ccfbf1;

        color:
            #0f766e;

        transform:
            translateY(-1px);
    }


    .mentor-delete-button {

        color:
            #ef4444;

        transition:
            background 0.25s ease,
            color 0.25s ease,
            transform 0.25s ease;
    }

    .mentor-delete-button:hover {

        background:
            #fef2f2;

        color:
            #dc2626;

        transform:
            translateY(-1px);
    }


    /* =========================================================
       MODAL
    ========================================================= */

    .mentor-modal {

        animation:
            mentorModalEnter
            0.3s
            ease-out;
    }

    @keyframes mentorModalEnter {

        from {
            opacity: 0;
            transform:
                scale(0.96)
                translateY(10px);
        }

        to {
            opacity: 1;
            transform:
                scale(1)
                translateY(0);
        }
    }


    /* =========================================================
       MODAL INPUT
    ========================================================= */

    .mentor-input,
    .mentor-select {

        transition:
            border-color 0.25s ease,
            box-shadow 0.25s ease;
    }

    .mentor-input:focus,
    .mentor-select:focus {

        border-color:
            #14b8a6 !important;

        box-shadow:
            0 0 0 3px
            rgba(20, 184, 166, 0.12);

        outline:
            none;
    }


    /* =========================================================
       MODAL SAVE BUTTON
    ========================================================= */

    .mentor-save-button {

        background:
            linear-gradient(
                135deg,
                #14b8a6,
                #0f9f91
            );

        color:
            white;

        box-shadow:
            0 5px 12px
            rgba(20, 184, 166, 0.18);

        transition:
            transform 0.25s ease,
            box-shadow 0.25s ease;
    }

    .mentor-save-button:hover {

        transform:
            translateY(-2px);

        box-shadow:
            0 9px 20px
            rgba(20, 184, 166, 0.27);
    }


    /* =========================================================
       CANCEL BUTTON
    ========================================================= */

    .mentor-cancel-button {

        background:
            #e6f3f1;

        color:
            #41615e;

        transition:
            background 0.25s ease;
    }

    .mentor-cancel-button:hover {

        background:
            #d6ebe8;
    }


    /* =========================================================
       EMPTY STATE
    ========================================================= */

    .mentor-empty-icon {

        color:
            #14b8a6;
    }

    .mentor-empty-title {

        color:
            #214b48;
    }

    .mentor-empty-description {

        color:
            #718582;
    }


    /* =========================================================
       RESPONSIVE
    ========================================================= */

    @media (max-width: 768px) {

        .mentor-table-container {
            border-radius:
                14px;
        }

        .mentor-page::before {
            left:
                -200px;
        }

        .mentor-page::after {
            right:
                -230px;
        }
    }

</style>


<!-- =========================================================
     MAIN PAGE
========================================================= -->

<div class="mentor-page">


    <!-- =====================================================
         HEADER
    ====================================================== -->

    <section class="mentor-header py-8">

        <div
            class="
                max-w-7xl
                mx-auto
                px-4
                sm:px-6
                lg:px-8
            "
        >

            <div
                class="
                    mentor-header-content
                    flex
                    flex-col
                    md:flex-row
                    md:items-center
                    md:justify-between
                    gap-4
                "
            >

                <!-- TITLE -->

                <div>

                    <h1
                        class="
                            mentor-title
                            text-3xl
                            font-bold
                        "
                    >
                        Kelola Mentor
                    </h1>

                    <p
                        class="
                            mentor-description
                            mt-1
                        "
                    >
                        Tambahkan, edit, dan hapus data mentor
                    </p>

                </div>


                <!-- ADD BUTTON -->

                <button
                    id="btn-add"
                    class="
                        mentor-add-button
                        inline-flex
                        items-center
                        px-6
                        py-2.5
                        font-medium
                        rounded-lg
                        transition
                    "
                >

                    <svg
                        class="w-5 h-5 mr-2 relative z-10"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M12 4v16m8-8H4"
                        />

                    </svg>

                    <span class="relative z-10">
                        Tambah Mentor
                    </span>

                </button>

            </div>

        </div>

    </section>


    <!-- =====================================================
         CONTENT
    ====================================================== -->

    <section class="py-8">

        <div
            class="
                mentor-content
                max-w-7xl
                mx-auto
                px-4
                sm:px-6
                lg:px-8
            "
        >


            <!-- =================================================
                 MODAL TAMBAH / EDIT
            ================================================== -->

            <div
                id="modal"
                class="
                    hidden
                    fixed
                    inset-0
                    z-50
                    overflow-y-auto
                "
            >

                <div
                    class="
                        flex
                        items-center
                        justify-center
                        min-h-screen
                        px-4
                    "
                >

                    <!-- OVERLAY -->

                    <div
                        class="
                            fixed
                            inset-0
                            bg-black/50
                        "
                        onclick="closeModal()"
                    ></div>


                    <!-- MODAL -->

                    <div
                        class="
                            mentor-modal
                            relative
                            bg-white
                            rounded-2xl
                            w-full
                            max-w-lg
                            shadow-2xl
                            p-8
                            my-8
                        "
                    >

                        <!-- MODAL HEADER -->

                        <div
                            class="
                                flex
                                items-center
                                justify-between
                                mb-6
                            "
                        >

                            <h2
                                id="modal-title"
                                class="
                                    text-xl
                                    font-bold
                                    text-[#173f3d]
                                "
                            >
                                Tambah Mentor
                            </h2>


                            <button
                                onclick="closeModal()"
                                class="
                                    text-gray-400
                                    hover:text-[#0f9f91]
                                    transition
                                "
                            >

                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />

                                </svg>

                            </button>

                        </div>


                        <!-- FORM -->

                        <form
                            id="mentor-form"
                            class="space-y-4"
                        >

                            <input
                                type="hidden"
                                id="edit-id"
                            >


                            <!-- NAMA -->

                            <div>

                                <label
                                    class="
                                        block
                                        text-sm
                                        font-medium
                                        text-[#405b59]
                                        mb-1
                                    "
                                >
                                    Nama Lengkap
                                </label>

                                <input
                                    id="input-nama"
                                    type="text"
                                    required
                                    class="
                                        mentor-input
                                        w-full
                                        px-4
                                        py-2.5
                                        border
                                        border-[#d7e8e5]
                                        rounded-lg
                                        bg-white
                                        text-[#23413f]
                                    "
                                >

                            </div>


                            <!-- BIDANG -->

                            <div>

                                <label
                                    class="
                                        block
                                        text-sm
                                        font-medium
                                        text-[#405b59]
                                        mb-1
                                    "
                                >
                                    Bidang
                                </label>

                                <select
                                    id="input-bidang"
                                    class="
                                        mentor-select
                                        w-full
                                        px-4
                                        py-2.5
                                        border
                                        border-[#d7e8e5]
                                        rounded-lg
                                        bg-white
                                        text-[#23413f]
                                    "
                                >

                                    <option value="teknologi">
                                        Teknologi
                                    </option>

                                    <option value="bisnis">
                                        Bisnis
                                    </option>

                                    <option value="desain">
                                        Desain
                                    </option>

                                    <option value="pendidikan">
                                        Pendidikan
                                    </option>

                                </select>

                            </div>


                            <!-- KEAHLIAN -->

                            <div>

                                <label
                                    class="
                                        block
                                        text-sm
                                        font-medium
                                        text-[#405b59]
                                        mb-1
                                    "
                                >
                                    Keahlian
                                </label>

                                <input
                                    id="input-keahlian"
                                    type="text"
                                    required
                                    class="
                                        mentor-input
                                        w-full
                                        px-4
                                        py-2.5
                                        border
                                        border-[#d7e8e5]
                                        rounded-lg
                                        bg-white
                                        text-[#23413f]
                                    "
                                >

                            </div>


                            <!-- PENGALAMAN -->

                            <div>

                                <label
                                    class="
                                        block
                                        text-sm
                                        font-medium
                                        text-[#405b59]
                                        mb-1
                                    "
                                >
                                    Pengalaman
                                </label>

                                <input
                                    id="input-pengalaman"
                                    type="text"
                                    required
                                    class="
                                        mentor-input
                                        w-full
                                        px-4
                                        py-2.5
                                        border
                                        border-[#d7e8e5]
                                        rounded-lg
                                        bg-white
                                        text-[#23413f]
                                    "
                                >

                            </div>


                            <!-- BUTTON -->

                            <div
                                class="
                                    flex
                                    gap-3
                                    pt-4
                                "
                            >

                                <button
                                    type="submit"
                                    class="
                                        mentor-save-button
                                        flex-1
                                        py-2.5
                                        font-medium
                                        rounded-lg
                                        transition
                                    "
                                >
                                    Simpan
                                </button>


                                <button
                                    type="button"
                                    onclick="closeModal()"
                                    class="
                                        mentor-cancel-button
                                        px-6
                                        py-2.5
                                        font-medium
                                        rounded-lg
                                        transition
                                    "
                                >
                                    Batal
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>


            <!-- =================================================
                 SEARCH
            ================================================== -->

            <div class="mb-6">

                <div
                    class="
                        relative
                        md:w-80
                    "
                >

                    <svg
                        class="
                            w-5
                            h-5
                            text-[#70a7a1]
                            absolute
                            left-3
                            top-1/2
                            -translate-y-1/2
                        "
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >

                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="
                                M21 21l-6-6
                                m2-5a7 7 0
                                11-14 0
                                7 7 0
                                0114 0z
                            "
                        />

                    </svg>

                    <input
                        id="search-input"
                        type="text"
                        placeholder="Cari mentor..."
                        class="
                            mentor-search
                            w-full
                            pl-10
                            pr-4
                            py-2.5
                            border
                            border-[#d7e8e5]
                            rounded-lg
                            bg-white
                            text-[#23413f]
                            placeholder-[#8ca4a1]
                        "
                    >

                </div>

            </div>


            <!-- =================================================
                 TABLE
            ================================================== -->

            <div
                class="
                    mentor-table-container
                "
            >

                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead
                            class="
                                mentor-table-head
                            "
                        >

                            <tr
                                class="
                                    text-left
                                    text-xs
                                    font-semibold
                                    uppercase
                                    tracking-wider
                                "
                            >

                                <th class="px-6 py-4">
                                    Mentor
                                </th>

                                <th class="px-6 py-4">
                                    Bidang
                                </th>

                                <th class="px-6 py-4">
                                    Keahlian
                                </th>

                                <th class="px-6 py-4">
                                    Pengalaman
                                </th>

                                <th class="px-6 py-4 text-right">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody
                            id="mentor-table"
                            class="
                                divide-y
                                divide-[#e7f1ef]
                            "
                        >
                        </tbody>

                    </table>

                </div>

            </div>


            <!-- =================================================
                 EMPTY STATE
            ================================================== -->

            <div
                id="empty-state"
                class="
                    hidden
                    text-center
                    py-16
                "
            >

                <svg
                    class="
                        mentor-empty-icon
                        w-14
                        h-14
                        mx-auto
                        mb-4
                    "
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="
                            M16 7a4 4 0
                            11-8 0
                            4 4 0
                            018 0z

                            M12 14
                            a7 7 0
                            00-7 7
                            h14
                            a7 7 0
                            00-7-7z
                        "
                    />

                </svg>

                <h3
                    class="
                        mentor-empty-title
                        text-xl
                        font-semibold
                        mb-2
                    "
                >
                    Mentor tidak ditemukan
                </h3>

                <p
                    class="
                        mentor-empty-description
                    "
                >
                    Coba ubah kata kunci pencarian
                </p>

            </div>

        </div>

    </section>

</div>


@endsection


@section('scripts')

<script>

    /* =========================================================
       BIDANG
    ========================================================= */

    const bidangLabel = {

        teknologi: {
            label: 'Teknologi',
            color: 'badge-teknologi'
        },

        bisnis: {
            label: 'Bisnis',
            color: 'badge-bisnis'
        },

        desain: {
            label: 'Desain',
            color: 'badge-desain'
        },

        pendidikan: {
            label: 'Pendidikan',
            color: 'badge-pendidikan'
        }

    };


    /* =========================================================
       DATA MENTOR
    ========================================================= */

    let mentors = [

        {
            id: 1,
            nama: 'Dr. Andi Wijaya',
            bidang: 'teknologi',
            keahlian: 'AI & Machine Learning',
            pengalaman: '15 tahun',
            avatar: 'AW'
        },

        {
            id: 2,
            nama: 'Rina Kusuma, MBA',
            bidang: 'bisnis',
            keahlian: 'Strategi Bisnis',
            pengalaman: '12 tahun',
            avatar: 'RK'
        },

        {
            id: 3,
            nama: 'Budi Santoso',
            bidang: 'teknologi',
            keahlian: 'Software Engineering',
            pengalaman: '10 tahun',
            avatar: 'BS'
        },

        {
            id: 4,
            nama: 'Siti Rahayu',
            bidang: 'desain',
            keahlian: 'UI/UX Design',
            pengalaman: '8 tahun',
            avatar: 'SR'
        },

        {
            id: 5,
            nama: 'Prof. Joko Susilo',
            bidang: 'pendidikan',
            keahlian: 'Metodologi Pengajaran',
            pengalaman: '20 tahun',
            avatar: 'JS'
        }

    ];


    let nextId = 6;


    /* =========================================================
       ELEMENT
    ========================================================= */

    const searchInput =
        document.getElementById(
            'search-input'
        );

    const tableBody =
        document.getElementById(
            'mentor-table'
        );

    const emptyState =
        document.getElementById(
            'empty-state'
        );

    const modal =
        document.getElementById(
            'modal'
        );

    const modalTitle =
        document.getElementById(
            'modal-title'
        );

    const form =
        document.getElementById(
            'mentor-form'
        );

    const editId =
        document.getElementById(
            'edit-id'
        );


    /* =========================================================
       RENDER TABLE
    ========================================================= */

    function renderTable() {

        const keyword =
            searchInput.value
                .toLowerCase()
                .trim();


        const filtered =
            mentors.filter(m => {

                return (

                    m.nama
                        .toLowerCase()
                        .includes(keyword)

                    ||

                    m.keahlian
                        .toLowerCase()
                        .includes(keyword)

                    ||

                    m.bidang
                        .toLowerCase()
                        .includes(keyword)

                );

            });


        /* =====================================================
           EMPTY STATE
        ====================================================== */

        emptyState.classList.toggle(
            'hidden',
            filtered.length > 0
        );


        /* =====================================================
           TABLE
        ====================================================== */

        tableBody.innerHTML =

            filtered

                .map(m => {

                    const b =
                        bidangLabel[
                            m.bidang
                        ];


                    return `

                        <tr
                            class="
                                mentor-row
                            "
                        >

                            <!-- MENTOR -->

                            <td class="px-6 py-4">

                                <div
                                    class="
                                        flex
                                        items-center
                                    "
                                >

                                    <div
                                        class="
                                            mentor-avatar
                                            w-10
                                            h-10
                                            rounded-lg
                                            flex
                                            items-center
                                            justify-center
                                            font-bold
                                            mr-3
                                            flex-shrink-0
                                        "
                                    >

                                        ${m.avatar}

                                    </div>

                                    <span
                                        class="
                                            mentor-name
                                            font-medium
                                        "
                                    >

                                        ${m.nama}

                                    </span>

                                </div>

                            </td>


                            <!-- BIDANG -->

                            <td class="px-6 py-4">

                                <span
                                    class="
                                        px-3
                                        py-1
                                        rounded-full
                                        text-xs
                                        font-medium
                                        ${b.color}
                                    "
                                >

                                    ${b.label}

                                </span>

                            </td>


                            <!-- KEAHLIAN -->

                            <td
                                class="
                                    px-6
                                    py-4
                                    mentor-info
                                "
                            >

                                ${m.keahlian}

                            </td>


                            <!-- PENGALAMAN -->

                            <td
                                class="
                                    px-6
                                    py-4
                                    mentor-info
                                "
                            >

                                ${m.pengalaman}

                            </td>


                            <!-- AKSI -->

                            <td class="px-6 py-4">

                                <div
                                    class="
                                        flex
                                        justify-end
                                        gap-2
                                    "
                                >

                                    <!-- EDIT -->

                                    <button
                                        onclick="editMentor(${m.id})"
                                        class="
                                            mentor-edit-button
                                            p-2
                                            rounded-lg
                                            transition
                                        "
                                        title="Edit Mentor"
                                    >

                                        <svg
                                            class="w-5 h-5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="
                                                    M11 5H6
                                                    a2 2 0
                                                    00-2 2v11
                                                    a2 2 0
                                                    002 2h11
                                                    a2 2 0
                                                    002-2v-5

                                                    m-1.414-9.414
                                                    a2 2 0
                                                    112.828 2.828

                                                    L11.828 15H9
                                                    v-2.828
                                                    l8.586-8.586z
                                                "
                                            />

                                        </svg>

                                    </button>


                                    <!-- DELETE -->

                                    <button
                                        onclick="deleteMentor(${m.id})"
                                        class="
                                            mentor-delete-button
                                            p-2
                                            rounded-lg
                                            transition
                                        "
                                        title="Hapus Mentor"
                                    >

                                        <svg
                                            class="w-5 h-5"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="
                                                    M19 7
                                                    l-.867 12.142
                                                    A2 2 0
                                                    0116.138 21
                                                    H7.862
                                                    a2 2 0
                                                    01-1.995-1.858
                                                    L5 7

                                                    m5 4v6
                                                    m4-6v6

                                                    m1-10V4
                                                    a1 1 0
                                                    00-1-1
                                                    h-4
                                                    a1 1 0
                                                    00-1 1v3

                                                    M4 7h16
                                                "
                                            />

                                        </svg>

                                    </button>

                                </div>

                            </td>

                        </tr>

                    `;

                })

                .join('');

    }


    /* =========================================================
       OPEN MODAL
    ========================================================= */

    function openModal(isEdit = false) {

        modal.classList.remove(
            'hidden'
        );

        document.body.style.overflow =
            'hidden';

        modalTitle.textContent =
            isEdit
                ? 'Edit Mentor'
                : 'Tambah Mentor';

    }


    /* =========================================================
       CLOSE MODAL
    ========================================================= */

    function closeModal() {

        modal.classList.add(
            'hidden'
        );

        document.body.style.overflow =
            '';

        form.reset();

        editId.value = '';

        modalTitle.textContent =
            'Tambah Mentor';

    }


    /* =========================================================
       EDIT MENTOR
    ========================================================= */

    function editMentor(id) {

        const m =
            mentors.find(
                x => x.id === id
            );


        if (!m) return;


        editId.value =
            m.id;

        document.getElementById(
            'input-nama'
        ).value =
            m.nama;

        document.getElementById(
            'input-bidang'
        ).value =
            m.bidang;

        document.getElementById(
            'input-keahlian'
        ).value =
            m.keahlian;

        document.getElementById(
            'input-pengalaman'
        ).value =
            m.pengalaman;


        openModal(true);

    }


    /* =========================================================
       DELETE MENTOR
    ========================================================= */

    function deleteMentor(id) {

        if (
            confirm(
                'Yakin ingin menghapus mentor ini?'
            )
        ) {

            mentors =
                mentors.filter(
                    m => m.id !== id
                );

            renderTable();

        }

    }


    /* =========================================================
       FORM SUBMIT
    ========================================================= */

    form.addEventListener(
        'submit',
        (e) => {

            e.preventDefault();


            const nama =
                document.getElementById(
                    'input-nama'
                ).value.trim();


            const bidang =
                document.getElementById(
                    'input-bidang'
                ).value;


            const keahlian =
                document.getElementById(
                    'input-keahlian'
                ).value.trim();


            const pengalaman =
                document.getElementById(
                    'input-pengalaman'
                ).value.trim();


            const id =
                editId.value;


            /* =================================================
               EDIT
            ================================================== */

            if (id) {

                const idx =
                    mentors.findIndex(
                        m =>
                            m.id ===
                            parseInt(id)
                    );


                if (idx !== -1) {

                    mentors[idx] = {

                        ...mentors[idx],

                        nama,
                        bidang,
                        keahlian,
                        pengalaman

                    };

                }

            }


            /* =================================================
               ADD
            ================================================== */

            else {

                mentors.push({

                    id:
                        nextId++,

                    nama,

                    bidang,

                    keahlian,

                    pengalaman,

                    avatar:
                        nama
                            .split(' ')
                            .filter(Boolean)
                            .map(
                                w => w[0]
                            )
                            .slice(0, 2)
                            .join('')
                            .toUpperCase()

                });

            }


            closeModal();

            renderTable();

        }
    );


    /* =========================================================
       ADD BUTTON
    ========================================================= */

    document
        .getElementById('btn-add')
        .addEventListener(
            'click',
            () => openModal(false)
        );


    /* =========================================================
       SEARCH
    ========================================================= */

    searchInput.addEventListener(
        'input',
        renderTable
    );


    /* =========================================================
       INITIAL RENDER
    ========================================================= */

    renderTable();

</script>

@endsection
