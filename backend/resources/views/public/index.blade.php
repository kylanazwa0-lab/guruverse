@extends('layouts.public')

@section('content')

<style>
  .pillar-card[role="button"] {
    cursor: pointer;
  }

  .search-input {
    color: #092b40;
  }

  .tag-pill {
    border: 0;
    font: inherit;
  }

  .pillar-card[role="button"]:focus-visible,
  .feature-card-link:focus-visible,
  .search-btn:focus-visible,
  .tag-pill:focus-visible {
    outline: 3px solid var(--primary-light);
    outline-offset: 3px;
  }

  .program-flow {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin: 60px auto 0;
    max-width: 1000px;
    position: relative;
  }

  .program-flow-step {
    flex: 1;
    text-align: center;
  }

  .program-flow-arrow {
    color: var(--border);
    font-size: 1.5rem;
  }

  @media (max-width: 1024px) {
    #pg-gurumengajar .feat-grid[style*="repeat(4"] {
      grid-template-columns: repeat(2, minmax(0, 1fr)) !important;
    }

    #pg-gurumengajar [style*="grid-template-columns: repeat(3"] {
      grid-template-columns: 1fr !important;
    }
  }

  @media (max-width: 768px) {
    #pg-guruinspira .feat-grid[style*="repeat(3"] {
      grid-template-columns: 1fr !important;
    }

    #pg-gurumengajar .feat-grid[style*="repeat(4"] {
      grid-template-columns: 1fr !important;
    }

    .program-flow {
      flex-direction: column;
      margin-top: 36px;
    }

    .program-flow-arrow {
      transform: rotate(90deg);
    }

    #pg-gurubelajar .detail-img img {
      width: 100% !important;
      max-width: 420px;
    }
  }

  @media (max-width: 520px) {
    .search-box {
      flex-direction: column;
      align-items: stretch;
      border-radius: 24px;
    }

    .search-btn {
      width: 100%;
    }
  }
</style>

@include('public.pages.home')
@endsection
